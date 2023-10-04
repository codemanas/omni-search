<script type="text/html" id="tmpl-cmswt-Result-itemTemplate--unified_data">
    <div class="hit-content">
        <# if(data._highlightResult.permalink !== undefined ) { #>
        <a href="{{{data._highlightResult.permalink.value}}}" rel="nofollow noopener"><h5 class="title">
                {{{data.formatted.post_title}}}</h5></a>
        <# } #>
        <div class="hit-description">{{{data.formatted.post_content}}}</div>
        <div class="hit-link">
            <a href="{{data.permalink}}"><?php _e( 'Read More...', 'search-with-typesense' ); ?></a>
        </div>
    </div>
</script>