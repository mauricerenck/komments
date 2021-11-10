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


### Show number of pending Komments in Panel

If you want to have the number of pending komments in view, you can add the `kommentsPending` panel field wherever you want. It's refreshing every minute, so you won't miss a new Komment. Just add the field to the blueprint:

```
fields:
  kommentsPending:
    type: kommentsPending
    label: Pending Komments
```

You could add it to your site.yml blueprint so you see the number of pending Komments right after logging in.

![komment section](../doc-assets/komments-pending.png)

---

