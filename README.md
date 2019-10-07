**Changelog**
5.0.0 - Change the 'add metas' hyperlink to use a querystring parameter instead of base64

**Example implementation:**

int the `<body`

    {if logged_in}
    {exp:url_metas:meta_admin_link}
    <style>
        .url_meta_admin_link {
            position: absolute;
            text-align: center;
            width: 100%;
            z-index: 1000;
        }
        .url_meta_admin_link a {
            background: black;
            color: white;
            font-size: 12px;
            padding: 8px;
        }
    </style>
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
