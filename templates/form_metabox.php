<?php 
    wp_nonce_field('cmb_save_data', 'mmp_save_pmetabox_nonce');

    global $post;

    $quality_movie = get_post_meta($post->ID, 'QualityMovie', true);

    $imbd_rank = get_post_meta($post->ID, 'IMDB', true);

    $released = get_post_meta($post->ID, 'Released', true);

    $duration = get_post_meta($post->ID, 'Duration', true);
?>
<style>
    p {
        display: block;
        width: 100%;
    }
    input {
        width: 100%;
        display: block;
        font-size: 1rem;
        color: black;
    }
    label {
        font-size: 0.7rem;
        color: black;
        display: block;
        margin-bottom: 0.5rem;
    }
</style>

<div class="container">
    <p>
        <label for="cmpQualityMovie">Quality Movie: </label>
        <input type="text" name="cmpQualityMovie" value="<?php echo $quality_movie; ?>" />
    </p>
    <p>
        <label for="cmpIMDB">IMDB: </label>
        <input type="float" name="cmpIMDB" value="<?php echo $imbd_rank; ?>" />
    </p>
    <p>
        <label for="cmpReleased">Released Date: </label>
        <input type="date" name="cmpReleased" value="<?php echo $released; ?>" />
    </p>
    <p>
        <label for="cmpDuration">Duration The Movie: </label>
        <input type="text" name="cmpDuration" value="<?php echo $duration; ?>" />
    </p>
</div>