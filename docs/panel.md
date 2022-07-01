# Adding Komments to the panel


## Moderation view

By default Komments comes with a panel view for moderation. You don't need to do anything for this. In the panel menu you should see an entry called "Komments". 

![the dashboard](../doc-assets/komments-dashboard.png)


## Adding Komments to your panel blueprint

if you use the panel, you may want to add the komments section to your blueprints like so:

```
sections:
    komments:
        extends: sections/komments
```

Add this to every blueprint you wish to enable komments on. This will allow you to enable/disable komments for each individual page and to see and edit the list of komments for that page.

![komment section](../doc-assets/komment-section.png)


## Show number of pending Komments in Kirby Panel Stats

Kirby 3.7 introduced the Panel Stats sections which allow you to build a little dashboard and show keymetrics. You can use this to show pending comments:

```
sections:
  stats:
    type: stats
    reports:
      - label: Pending Comments
        value: "{{ site.numberOfPendingComments }}"
        info: "Possible spam: {{ site.numberOfSpamComments }}"
        link: https://getkirby.com/shop
        theme: negative
```

![komment section](../doc-assets/komment-stats.png)

To get the number of pending comments use the site method `numberOfPendingComments`. To get pending comments marked as spam use `numberOfSpamComments`

To learn more about Kirby stats, please have a look here: https://getkirby.com/docs/reference/panel/sections/stats

## Show number of pending Komments in Panel

If you want to have the number of pending komments in view, you can add the `kommentsPending` panel field wherever you want. It's refreshing every minute, so you won't miss a new Komment. Just add the field to the blueprint:

```
fields:
  kommentsPending:
    type: kommentsPending
    label: Pending Komments
```

You could add it to your site.yml blueprint so you see the number of pending Komments right after logging in.

![komment section](../doc-assets/komments-pending.png)


