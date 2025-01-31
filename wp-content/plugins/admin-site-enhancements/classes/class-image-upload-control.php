<?php

namespace ASENHA\Classes;

use Imagick;
/**
 * Class for Image Upload Control module
 *
 * @since 6.9.5
 */
class Image_Upload_Control {
    public $png_is_transparent;

    /**
     * Constructor
     * @since 7.4.3
     */
    function __construct() {
        $this->png_is_transparent = false;
    }

    /**
     * Handler for image uploads. Convert and resize images.
     *
     * @since 4.3.0
     */
    public function image_upload_handler( $upload ) {
        $applicable_mime_types = array(
            'image/bmp',
            'image/x-ms-bmp',
            'image/png',
            'image/jpeg',
            'image/jpg',
            'image/webp'
        );
        if ( in_array( $upload['type'], $applicable_mime_types ) ) {
            // Exlude from conversion and resizing images with filenames ending with '-nr', e.g. birds-nr.png
            if ( false !== strpos( $upload['file'], '-nr.' ) ) {
                return $upload;
            }
            // Convert BMP
            if ( 'image/bmp' === $upload['type'] || 'image/x-ms-bmp' === $upload['type'] ) {
                $upload = $this->maybe_convert_image( 'bmp', $upload );
            }
            // Convert PNG without transparency
            if ( 'image/png' === $upload['type'] ) {
                $upload = $this->maybe_convert_image( 'png', $upload );
            }
            // At this point, BMPs and non-transparent PNGs are already converted to JPGs, unless excluded with '-nr' suffix.
            // Let's perform resize operation as needed, i.e. if image dimension is larger than specified
            $mime_types_to_resize = array(
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/webp'
            );
            if ( !is_wp_error( $upload ) && in_array( $upload['type'], $mime_types_to_resize ) && filesize( $upload['file'] ) > 0 ) {
                // https://developer.wordpress.org/reference/classes/wp_image_editor/
                $wp_image_editor = wp_get_image_editor( $upload['file'] );
                if ( !is_wp_error( $wp_image_editor ) ) {
                    $image_size = $wp_image_editor->get_size();
                    $options = get_option( ASENHA_SLUG_U, array() );
                    $max_width = $options['image_max_width'];
                    $max_height = $options['image_max_height'];
                    // Check upload image's dimension and only resize if larger than the defined max dimension
                    if ( isset( $image_size['width'] ) && $image_size['width'] > $max_width || isset( $image_size['height'] ) && $image_size['height'] > $max_height ) {
                        $wp_image_editor->resize( $max_width, $max_height, false );
                        // false is for no cropping
                        if ( 'image/jpg' === $upload['type'] || 'image/jpeg' === $upload['type'] ) {
                            $wp_image_editor->set_quality( 90 );
                            // default is 82
                        }
                        $wp_image_editor->save( $upload['file'] );
                    }
                }
            }
        }
        return $upload;
    }

    /**
     * Convert BMP or PNG without transparency into JPG
     *
     * @since 4.3.0
     */
    public function maybe_convert_image( $file_extension, $upload ) {
        $image_object = null;
        // Get image object from uploaded BMP/PNG
        if ( 'bmp' === $file_extension ) {
            if ( is_file( $upload['file'] ) ) {
                // Generate image object from BMP for conversion to JPG later
                if ( function_exists( 'imagecreatefrombmp' ) ) {
                    // PHP >= v7.2
                    $image_object = imagecreatefrombmp( $upload['file'] );
                } else {
                    // PHP < v7.2
                    require_once ASENHA_PATH . 'includes/bmp-to-image-object.php';
                    $image_object = bmp_to_image_object( $upload['file'] );
                }
            }
        }
        if ( 'png' === $file_extension ) {
            // Detect alpha/transparency in PNG
            $this->png_is_transparent = false;
            if ( is_file( $upload['file'] ) ) {
                if ( function_exists( 'imagecreatefrompng' ) ) {
                    // GD library is present, so 'imagecreatefrompng' function is available
                    // Generate image object from PNG for potential conversion to JPG later.
                    $image_object = imagecreatefrompng( $upload['file'] );
                    // Get image dimension
                    list( $width, $height ) = getimagesize( $upload['file'] );
                    // Run through pixels until transparent pixel is found
                    for ($x = 0; $x < $width; $x++) {
                        for ($y = 0; $y < $height; $y++) {
                            $pixel_color_index = imagecolorat( $image_object, $x, $y );
                            $pixel_rgba = imagecolorsforindex( $image_object, $pixel_color_index );
                            // array of red, green, blue and alpha values
                            if ( $pixel_rgba['alpha'] > 0 ) {
                                // a pixel with alpha/transparency has been found
                                // alpha value range from 0 (completely opaque) to 127 (fully transparent).
                                // Ref: https://www.php.net/manual/en/function.imagecolorallocatealpha.php
                                $this->png_is_transparent = true;
                                break 2;
                                // Break both 'for' loops
                            }
                        }
                    }
                } else {
                    if ( class_exists( 'Imagick' ) ) {
                        $imagick = new Imagick();
                        $imagick->readImage( $upload['file'] );
                        // Ref: https://stackoverflow.com/a/52295997
                        // Ref: https://www.php.net/manual/en/imagick.getimagechannelrange.php
                        // If the channel is defined, and has any transparent areas across any frame, then maxima will always be greater then minima.
                        // If the channel is NOT defined, then minima will be Inf placeholder, and maxima will be -Inf placeholder, so the above check will still work.
                        $alpha_range = $imagick->getImageChannelRange( Imagick::CHANNEL_ALPHA );
                        $this->png_is_transparent = $alpha_range['minima'] < $alpha_range['maxima'];
                    }
                }
            }
            // Do not convert PNG with alpha/transparency
            if ( $this->png_is_transparent ) {
                return $upload;
            }
        }
        // Let's convert BMP and non-transparent PNG into JPG
        if ( is_object( $image_object ) || class_exists( 'Imagick' ) ) {
            $wp_uploads = wp_upload_dir();
            $old_filename = wp_basename( $upload['file'] );
            // Assign new, unique file name for the converted image
            // $new_filename    = wp_basename( str_ireplace( '.' . $file_extension, '.jpg', $old_filename ) );
            $new_filename = str_ireplace( '.' . $file_extension, '.jpg', $old_filename );
            $new_filename = wp_unique_filename( dirname( $upload['file'] ), $new_filename );
            // original image is always deleted in ASE Free
            $keep_original_image = false;
            $converted_to_jpg = false;
        }
        if ( is_object( $image_object ) ) {
            // When image object creation is successful
            // When conversion from BMP/PNG to JPG is successful using GD. Last parameter is JPG quality (0-100).
            if ( imagejpeg( $image_object, $wp_uploads['path'] . '/' . $new_filename, 90 ) ) {
                $converted_to_jpg = true;
            }
        } else {
            // When image object creation with imagecreatefrombmp(), bmp_to_image_object() or imagecreatefrompng() is not successful, we use Imagick to convert from BMP and non-transparent PNG to JPG.
            if ( class_exists( 'Imagick' ) ) {
                $imagick = new Imagick();
                $imagick->readImage( $upload['file'] );
                $imagick->setImageCompressionQuality( 90 );
                $imagick->setImageFormat( 'jpg' );
                // $imagick->setFormat( 'jpg' );
                if ( $imagick->writeImage( $wp_uploads['path'] . '/' . $new_filename ) ) {
                    $converted_to_jpg = true;
                }
                // Clear the Imagick object
                $imagick->clear();
                $imagick->destroy();
            }
        }
        if ( $converted_to_jpg ) {
            // Delete original BMP / PNG
            if ( !$keep_original_image ) {
                unlink( $upload['file'] );
            }
            // Add converted JPG info into $upload
            $upload['file'] = $wp_uploads['path'] . '/' . $new_filename;
            $upload['url'] = $wp_uploads['url'] . '/' . $new_filename;
            $upload['type'] = 'image/jpeg';
        }
        return $upload;
    }

    /**
     * Generate image object from PNG/JPG with GD library
     * 
     * @since 6.9.11
     */
    public function gd_generate_webp(
        $file,
        $file_extension,
        $webp_path,
        $webp_conversion_quality
    ) {
        if ( 'png' == $file_extension ) {
            $image_object = imagecreatefrompng( $file );
            if ( $this->png_is_transparent ) {
                imagepalettetotruecolor( $image_object );
            }
        }
        if ( 'jpg' == $file_extension || 'jpeg' == $file_extension ) {
            $image_object = imagecreatefromjpeg( $file );
        }
        // When creation of image object from PNG/JPG is successful. let's generate WebP image
        // Second parameter is file path, last parameter is WebP quality (0-100).
        if ( !is_null( $image_object ) && is_object( $image_object ) ) {
            imagewebp( $image_object, $webp_path, $webp_conversion_quality );
        }
    }

}
