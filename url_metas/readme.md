    {exp:url_metas}
    <title>{if "{meta_title}" != ""}{meta_title}{if:else}{if layout:title}{layout:title} | {/if}SITE NAME HERE{/if}</title>
    {if "{meta_description}" != ""}<meta name="description" content="{meta_description}">{/if}
    {if "{meta_keywords}" != ""}<meta name="keywords" content="{meta_keywords}">{/if}
    {/exp:url_metas}


    {exp:url_metas:meta_admin_link}
