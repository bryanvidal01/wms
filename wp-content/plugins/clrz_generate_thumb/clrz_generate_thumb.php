<?php
/*
  Plugin Name: Clrz Generate thumb
  Plugin URI: http://colorz.fr/#GenerateThumb
  Description: GenerateThumb.
  Author: Colorz
  Version: 1.4
  Author URI: http://colorz.fr/
 */

define( 'GENERATE_POST_THUMB_TYPE', 'post' );

/* ----------------------------------------------------------
  Don't touch below !
---------------------------------------------------------- */

class Clrz_GenerateThumb {

    function Clrz_GenerateThumb() {
        add_action( 'admin_menu', array( &$this, 'addMenu' ) );
        add_action( 'admin_init', array( &$this, 'admin_init' ) );
        add_action( 'wp_ajax_clrz_init_thumb', array( &$this, 'initThumb' ) );
    }


    function admin_init() {
        wp_enqueue_script( 'jquery' );
    }

    function addMenu() {
        add_menu_page( 'Thumb Manager', 'Thumb Manager', 'manage_categories', 'manage-clrzthumb', array( &$this, 'pageManage' ) );
    }

    function _generate_thumb( $att_id ) {
        wp_update_attachment_metadata( $att_id, $this->wp_generate_attachment_metadata( $att_id, get_attached_file( $att_id ) ) );
    }


    function shell( $arg ) {
        global $wpdb;
        switch ( $arg ) {
        case 'all':
            $this->generate_attachements_sql( "SELECT ID as att_ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_mime_type LIKE 'image%'" );
            break;
        case 'posts':
            $this->generate_attachements_sql( "SELECT p.ID AS ID,att.ID AS att_ID FROM `" . $wpdb->posts . "`
        AS p LEFT JOIN (SELECT * FROM `" . $wpdb->posts . "` WHERE post_type = 'attachment' AND post_mime_type LIKE 'image%' ORDER BY menu_order DESC) AS att ON ( p.ID = att.post_parent AND att.post_type = 'attachment' AND att.post_mime_type LIKE 'image%') WHERE p.post_type = '".GENERATE_POST_THUMB_TYPE."' AND p.post_status = 'publish' GROUP BY p.ID ORDER BY p.post_date DESC " );
            break;
        }
    }

    function generate_attachements_sql( $query ) {

        global $wpdb;

        $attachments = $wpdb->get_results( $query );
        $size = sizeof( $attachments );
        $i = 0;
        foreach ( $attachments as $att ) {

            $this->_generate_thumb( $att->att_ID );
            $i++;
            echo "$i / $size".PHP_EOL;

        }
    }

    function initThumb() {

        if ( !wp_verify_nonce( $_POST['clrz_nonce'], 'clrz-nonce' ) )
            die( "Security check" );


        $res = wp_update_attachment_metadata( $_POST['thumbID'], $this->wp_generate_attachment_metadata( $_POST['thumbID'], get_attached_file( $_POST['thumbID'] ) ) );

        //wp_generate_attachment_metadata($_POST['thumbID'],get_attached_file($_POST['thumbID']));

        echo 'done <br />' . get_the_title( $_POST['postID'] ) .
        '<br /><img style="max-width:50px;max-height:50px;" src="' . get_post_thumb( 'thumbnail', $_POST['postID'], true ) . '"/><br />';
        die;
    }

    function wp_basename( $path, $suffix = '' ) {
        return urldecode( basename( str_replace( '%2F', '/', urlencode( $path ) ), $suffix ) );
    }

    function wp_generate_attachment_metadata( $attachment_id, $file ) {
        $attachment = get_post( $attachment_id );

        //$file= str_replace('/home.10.22/garanced/www/','/home/sartorialist/public_html/garancedore/',$file);

        $_file=explode( '/wp-content/uploads/', $file );

        if ( $_file[1] )
            $file=ABSPATH.'/wp-content/uploads/'.$_file[1];


        $metadata = array();

        if ( preg_match( '!^image/!', get_post_mime_type( $attachment ) ) && file_is_displayable_image( $file ) ) {
            $imagesize = getimagesize( $file );
            //print_r($imagesize);
            $metadata['width'] = $imagesize[0];
            $metadata['height'] = $imagesize[1];
            list( $uwidth, $uheight ) = wp_constrain_dimensions( $metadata['width'], $metadata['height'], 128, 96 );
            $metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";

            // Make the file path relative to the upload dir
            $metadata['file'] = _wp_relative_upload_path( $file );

            // make thumbnails and other intermediate sizes
            global $_wp_additional_image_sizes;

            foreach ( get_intermediate_image_sizes() as $s ) {
                $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => FALSE );
                if ( isset( $_wp_additional_image_sizes[$s]['width'] ) )
                    $sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] ); // For theme-added sizes
                else
                    $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
                if ( isset( $_wp_additional_image_sizes[$s]['height'] ) )
                    $sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] ); // For theme-added sizes
                else
                    $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
                if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) )
                    $sizes[$s]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] ); // For theme-added sizes
                else
                    $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
            }

            $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

            foreach ( $sizes as $size => $size_data ) {
                $resized = $this->image_make_intermediate_size( $file, $size_data['width'], $size_data['height'], $size_data['crop'] );
                if ( $resized )
                    $metadata['sizes'][$size] = $resized;
            }

            // fetch additional metadata from exif/iptc
            $image_meta = wp_read_image_metadata( $file );
            if ( $image_meta )
                $metadata['image_meta'] = $image_meta;

        }

        return apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
    }

    function image_make_intermediate_size( $file, $width, $height, $crop = false ) {
        if ( $width || $height ) {
            $resized_file = $this->image_resize( $file, $width, $height, $crop );
            if ( !is_wp_error( $resized_file ) && $resized_file && $info = getimagesize( $resized_file ) ) {
                $resized_file = apply_filters( 'image_make_intermediate_size', $resized_file );
                return array(
                    'file' => $this->wp_basename( $resized_file ),
                    'width' => $info[0],
                    'height' => $info[1],
                );
            }
        }
        return false;
    }

    function image_resize( $file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 90 ) {

        $image = wp_load_image( $file );
        if ( !is_resource( $image ) )
            return new WP_Error( 'error_loading_image', $image, $file );

        $size = @getimagesize( $file );
        if ( !$size )
            return new WP_Error( 'invalid_image', __( 'Could not read image size' ), $file );
        list( $orig_w, $orig_h, $orig_type ) = $size;

        $dims = image_resize_dimensions( $orig_w, $orig_h, $max_w, $max_h, $crop );
        if ( !$dims )
            return new WP_Error( 'error_getting_dimensions', __( 'Could not calculate resized image dimensions' ) );
        list( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h ) = $dims;

        $newimage = wp_imagecreatetruecolor( $dst_w, $dst_h );

        imagecopyresampled( $newimage, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );

        // convert from full colors to index colors, like original PNG.
        if ( IMAGETYPE_PNG == $orig_type && function_exists( 'imageistruecolor' ) && !imageistruecolor( $image ) )
            imagetruecolortopalette( $newimage, false, imagecolorstotal( $image ) );

        // we don't need the original in memory anymore
        imagedestroy( $image );

        // $suffix will be appended to the destination filename, just before the extension
        if ( !$suffix )
            $suffix = "{$dst_w}x{$dst_h}";

        $info = pathinfo( $file );
        $dir = $info['dirname'];
        $ext = $info['extension'];
        $name = $this->wp_basename( $file, ".$ext" );

        if ( !is_null( $dest_path ) and $_dest_path = realpath( $dest_path ) )
            $dir = $_dest_path;
        $destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

        if ( file_exists( $destfilename ) )
            return $destfilename;

        if ( IMAGETYPE_GIF == $orig_type ) {
            if ( !imagegif( $newimage, $destfilename ) )
                return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid' ) );
        } elseif ( IMAGETYPE_PNG == $orig_type ) {
            if ( !imagepng( $newimage, $destfilename ) )
                return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid' ) );
        } else {
            // all other formats are converted to jpg
            $destfilename = "{$dir}/{$name}-{$suffix}.jpg";
            if ( !imagejpeg( $newimage, $destfilename, apply_filters( 'jpeg_quality', $jpeg_quality, 'image_resize' ) ) )
                return new WP_Error( 'resize_path_invalid', __( 'Resize path invalid' ) );
        }

        imagedestroy( $newimage );

        // Set correct file permissions
        $stat = stat( dirname( $destfilename ) );
        $perms = $stat['mode'] & 0000666; //same permissions as parent folder, strip off the executable bits
        @ chmod( $destfilename, $perms );

        return $destfilename;
    }

    function pageManage() {
?>
        <script>

            var clrz_ajax=[];

            clrz_ajax['nonce'] = "<?php echo wp_create_nonce( 'clrz-nonce' ) ?>";
            clrz_ajax['ajaxurl'] = "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php";




            jQuery(window).ready(function(){

                var batch = jQuery(".batch");
                var i=-1;
                var stop = true;


                function next()
                {
                    if(stop==true)
                        return;
                    if(i>=batch.length)
                        return;
                    i=i+1;
                    jQuery('#count').text(i+'/'+batch.length);
                    CLRZrequest();
                }

                function CLRZrequest()
                {
                    if(!jQuery(batch[i]).attr("id"))
                    {
                        next();
                        return false;
                    }
                    jQuery.post(clrz_ajax['ajaxurl'], { action: "clrz_init_thumb",clrz_nonce: clrz_ajax['nonce'],thumbID:jQuery(batch[i]).attr("id"),postID: jQuery(batch[i]).attr("rel")},
                    function(data){
                        jQuery(batch[i]).html('').append(data);
                        next();
                    },"html");



                }

                next();

                jQuery('#stop').click(function(e){

                    if(stop==true)
                        stop = false;
                    else
                        stop=true;

                    next();
                });


            });
        </script>
        <div class="wrap">
            <div id="icon-tools" class="icon32"><br /></div>
            <h2>Batch Thumb</h2>
            <p><a id="stop" style="cursor: pointer;">start / stop </a></p><div id="count"></div><br/>
            <div style="overflow:auto;height:400px;">
        <?php
        global $wpdb;

        $query_base = "SELECT
            p.ID AS ID,
            att.ID AS img
        FROM `" . $wpdb->posts . "`
        AS p LEFT JOIN (SELECT * FROM `" . $wpdb->posts . "` WHERE post_type = 'attachment' AND post_mime_type LIKE 'image%' ORDER BY menu_order DESC)
        AS att ON ( p.ID = att.post_parent AND att.post_type = 'attachment' AND att.post_mime_type LIKE 'image%')
        WHERE
            p.post_type = '".GENERATE_POST_THUMB_TYPE."'
            AND p.post_status = 'publish'
        GROUP BY p.ID
        ORDER BY p.post_date DESC ";


        /*  $query_base2 ="SELECT p.ID AS ID,att.ID AS img
                FROM `" . $wpdb->posts . "` AS p
                LEFT JOIN " . $wpdb->posts . " AS att ON ( p.ID = att.post_parent   AND att.post_type = 'attachment' AND att.post_mime_type LIKE 'image%')
                WHERE p.post_type = '".GENERATE_POST_THUMB_TYPE."' AND p.post_status = 'publish' AND p.ID IN(2953) GROUP BY p.ID ORDER BY p.post_date DESC ";
    */

        $query_debug = "    SELECT p.ID AS ID,att.ID AS img,met.meta_value FROM `wp_posts` AS p
    LEFT JOIN wp_posts AS att ON ( p.ID = att.post_parent AND att.post_type = 'attachment' AND att.post_mime_type LIKE 'image%')
    left JOIN wp_postmeta AS met ON (met.post_id=att.ID AND met.meta_key='_wp_attached_file')

    WHERE p.post_type = '".GENERATE_POST_THUMB_TYPE."'
    AND p.post_status = 'publish'
    AND met.meta_value  NOT LIKE '2%'

    GROUP BY p.ID ORDER BY p.post_date DESC";



        $posts = $wpdb->get_results( $query_base );

        foreach ( $posts as $post ) {

            echo 'post ' . $post->ID . ' • <span style="color: #999;">img '.$post->img. '</span> => <a class="batch" rel="' . $post->ID . '" id="' . $post->img . '">post ' . $post->ID . '</a><br/>';
        }
?>
            </div>

            <style>
                .item:hover input{background:#999;color:#fff}
            </style>

                <?php
    }

}

$Clrz_GenerateThumb = new Clrz_GenerateThumb();