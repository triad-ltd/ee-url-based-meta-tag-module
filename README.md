**Changelog**
5.0.1 - Change how defaults work, update head snippet
5.0.0 - Change the 'add metas' hyperlink to use a querystring parameter instead of base64

**Example implementation**

in the `<body>`

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
        {if:elseif layout:title}
            <title>{layout:title} | {site_name}</title>
        {if:elseif "{default_meta_title}" != ""}
            <title>{default_meta_title}</title>
        {/if}
        {if "{meta_description}" != ""}
            <meta name="description" content="{meta_description}">
        {if:elseif layout:meta_description}
            <meta name="description" content="{layout:meta_description}" />
        {if:elseif "{default_meta_description}" != ""}
            <meta name="description" content="{default_meta_description}" />
        {/if}
        {if "{meta_keywords}" != ""}
            <meta name="keywords" content="{meta_keywords}">
        {if:elseif layout:meta_keywords}
            <meta name="keywords" content="{layout:meta_keywords}">
        {if:elseif "{default_meta_keywords}" != ""}
            <meta name="keywords" content="{default_meta_keywords}">
        {/if}
    {/exp:url_metas}
