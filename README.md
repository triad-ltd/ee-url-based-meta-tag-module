**Example implementation:**

int the `<body`

    {if logged_in_member_group == "1"}
	    {exp:url_metas:meta_admin_link}
    {/if}

in the `<head>`

    {exp:url_metas parse="inward"}
        {if "{meta_title}" != ""}
        <title>{meta_title}</title>
        {if:else}
        <title>{if layout:title}{layout:title} &raquo; {/if} DEFAULT SITE NAME/TITLE</title>
        {/if}
        {if "{meta_description}" != ""}
        <meta name="description" content="{meta_description}">
        {if:else}
        <meta name="description" content="{if layout:meta_desc}{layout:meta_desc}{if:else}DEFAULT DESCRIPTION CONTENT{/if}" />
        {/if}
        {if "{meta_keywords}" != ""}
        <meta name="keywords" content="{meta_keywords}">
        {/if}
    {/exp:url_metas}
