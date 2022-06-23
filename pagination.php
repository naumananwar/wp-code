<?php 
/**
 * A pagination function
 * @param integer $range: The range of the slider, works best with even numbers
 * Used WP functions:
 * get_pagenum_link($i) - creates the link, e.g. http://site.com/page/4
 * previous_posts_link(' ‚ '); - returns the Previous page link
 * next_posts_link(' é '); - returns the Next page link
 * http://robertbasic.com/blog/wordpress-paging-navigation/
 * tweaked by tdB ...
 */
function get_pagination($range = 4) {
global $paged, $wp_query;

// How much pages do we have?
if ( !$max_page ) {
    $max_page = $wp_query->max_num_pages;
}

// We need the pagination only if there is more than 1 page
if ( $max_page > 1 ) {
    if ( !$paged ) $paged = 1;

    echo '<div class="postpagination">';

    // To the previous page
    previous_posts_link('Prev');

    if ( $paged >= $range ) echo '<a href="' . get_pagenum_link(1) . '">1</a>';
    if ( $paged >= ($range + 1) ) echo '<span class="page-numbers">&hellip;</span>';

    // We need the sliding effect only if there are more pages than is the sliding range
    if ( $max_page > $range ) {
        // When closer to the beginning
        if ( $paged < $range ) {
            for ( $i = 1; $i <= ($range + 1); $i++ ) {
                    echo ( $i != $paged ) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
        // When closer to the end
        } elseif ( $paged >= ($max_page - ceil(($range/2))) ) {
            for ( $i = $max_page - $range; $i <= $max_page; $i++ ) {
                echo ( $i != $paged ) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
        // Somewhere in the middle
        } elseif ( $paged >= $range && $paged < ($max_page - ceil(($range/2))) ) {
            for ( $i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++ ) {
                echo ($i != $paged) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
        }
    // Less pages than the range, no sliding effect needed
    } else {
        for ( $i = 1; $i <= $max_page; $i++ ) {
                echo ($i != $paged) ? '<a href="' . get_pagenum_link($i) .'">'.$i.'</a>' : '<span class="this-page">'.$i.'</span>';
            }
    }

    // On the last page, don't put the Last page link
    if ( $paged <= $max_page - ($range - 1) ) echo '<span class="page-numbers">&hellip;</span><a href="' . get_pagenum_link($max_page) . '">' . $max_page . '</a>';

    // Next page
    next_posts_link('Next');

    echo '</div><!-- postpagination -->';
}
}
