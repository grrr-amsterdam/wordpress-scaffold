<?php

namespace Grrr\WP\Import;

class Import
{
    public function __construct() {

        // create empty post
        $this->aPost = array();

    }

    public function getByMeta( $key, $value ) {

        if(empty($this->aPost['post_type'])) {
            die("Set: 'post_type' to continue...");
        }

        $aArgs = array(
            'post_type'      => array($this->aPost['post_type']),
            'posts_per_page' => 1,
            'meta_key'       => $key,
            'meta_value'     => $value,
            'post_status'    => 'any',
        );

        $oQuery = new \WP_Query( $aArgs );
        return $oQuery->post;

    }

    public function set( $key, $value ) {

        // fix date
        if( $key == 'post_date' ) {

            if( !is_numeric( $value ) ) {
                $value = strtotime( $value );
            }

            $value = date("Y-m-d H:i:s", $value);
        }

        // fix ID key
        if( $key == 'id' ) {
            $key = 'ID';
        }

        // check if category is value
        if( $key == 'post_category' && !is_array( $value ) ) {
            $value = array( $value );
        }

        // set key and value
        $this->aPost[$key] = $value;

    }

    public function setTag( $tag ) {

        if( !is_array( $this->aPost['tags'] ) ) {
            $this->aPost['tags'] = array();
        }

        $this->aPost['tags'][] = $tag;

    }

    public function setMeta( $key, $value ) {

        // set key and value
        $this->aPost['meta'][$key] = $value;

    }


    public function insert() {

        // return id if already exists
        if($oPost = get_page_by_title($this->aPost['post_title'], 'OBJECT', $this->aPost['post_type'])) {
            $this->aPost['ID'] = $oPost->ID;
            return $this->aPost['ID'];
        }

        $this->aPost['ID'] = wp_insert_post( $this->aPost );

        return $this->aPost['ID'];

    }

    public function update() {

        $this->aPost['ID'] = wp_update_post( $this->aPost );

        return $this->aPost['ID'];

    }


    public function insertTags() {

        wp_set_post_tags( $this->aPost['ID'], $this->aPost['tags'] );

    }

    public function insertMeta() {

        if( !isset( $this->aPost['ID'] ) )
            return;

        if( !is_array( $this->aPost['meta'] ) )
            return;

        foreach( $this->aPost['meta'] as $key => $value ) {
            update_post_meta($this->aPost['ID'], $key, $value);
        }

    }

    public function setAcfField( $key, $value ) {

        // set key and value
        $this->aPost['acf'][$key] = $value;

    }

    public function insertAcfFields() {

        foreach( $this->aPost['acf'] as $key => $value ) {

            $this->InsertAcfField( $key, $value );

        }

    }

    public function InsertAcfField( $field_key, $value ) {

        update_field($field_key, $value, $this->aPost['ID']);

    }

    public function setImages( $value ) {

        // set key and value
        $this->aPost['images'][] = $value;

    }

    public function insertImages() {

        if( is_array( $this->aPost['images'] ) ) {

            foreach( $this->aPost['images'] as $image ) {

                $this->InsertImage( $image );

            }
        }
    }

    public function InsertImage( $image ) {

        $filename  = basename($image);
        if(strpos($filename, '?')) {
            // save image filename
            $filename = strstr($filename, '?', true);
        }

        $filetitle = substr($filename, 0, strrpos($filename, '.'));
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image);

        if( !empty( $image_data ) ) {

            $filename = sanitize_file_name( sanitize_title_with_dashes( $this->aPost['post_title'] )) . '_' .  $filename;

            if(wp_mkdir_p($upload_dir['path'])) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }
            file_put_contents($file, $image_data);

            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_excerpt'   => $this->aPost['post_title'],
                'post_content'   => $this->aPost['post_title'],
                'post_title'     => $this->aPost['post_title'],
                'post_status'    => 'inherit'
            );

            $attach_id = wp_insert_attachment( $attachment, $file, $this->aPost['ID'] );

            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            $image2Url = wp_get_attachment_url($attach_id);

            // set featured post
            update_post_meta( $this->aPost['ID'], '_thumbnail_id', $attach_id );

            // set image ids
            $this->aPost['imageIds'][] = $attach_id;
        }
    }

    public function InsertAcfImages( $field_key ) {

        foreach( $this->aPost['imageIds'] as $key => $id ) {

            update_field('photos_' . $key . '_image', $id, $this->aPost['ID']);

        }

        update_field('photos', count( $this->aPost['imageIds'] ), $this->aPost['ID']);
        update_field('_photos', $field_key, $this->aPost['ID']);

    }

    public function InsertCustomCategory( $id ) {

        global $wpdb;

        // set post id
        $postId = $this->aPost['ID'];

        // create sql
        $sql = "
            INSERT INTO  $wpdb->prefix . `term_relationships` (
                `object_id` ,
                `term_taxonomy_id` ,
                `term_order`
            )
            VALUES (
                $postId,  $id,  '0'
            );
        ";

        // insert
        $wpdb->query($sql);

    }

}
