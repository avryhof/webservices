WebServices
===========

Some Basic classes for handling Web services. Starting with a cURL Class, and extending to use the REST services for some web service provicers.

So far we have -
* Issuu
* Meetup

CurlClass
=========

This is a foundation class that just provides easy ways to call curl functionality.

Issuu
=====

documentList() - Get the Document list
foldersList() - Get the Folders List
getEmbed() - Get the Embed code for a document

```php
    $iss = new issuu($issuu_apikey, $issuu_apisecret);

    $docs = $iss->documentList(array(
        "resultOrder" => "desc",
        "documentSortBy" => "publishDate"
    ));

    foreach($docs->result as $doc) {
        ?>
        <article>
            <h3><i class="icon-book-open"></i> <a href="http://issuu.com/<?= $doc->document->username; ?>/docs/<?= $doc->document->name; ?>" target="_blank"><?= $doc->document->title; ?></a></h3>
            <section><?= date('F j, Y',strtotime($doc->document->publishDate)); ?> &mdash; <a href="http://issuu.com/<?= $doc->document->username; ?>/docs/<?= $doc->document->name; ?>" target="_blank">Read Now&hellip;</a></section>
        </article>
        <?
    }
```

Meetup
======

getOpenEvents()
getEvents()

```php
    $meetup = new Meetup($meetup_key);

    $events = $meetup->getEvents($meetup_group, array("status" => "upcoming"));

    foreach ($events->results as $event) {
        ?>

        <article>
            <h3><a href="<?= $event->event_url; ?>" target="_blank"><?= $event->name; ?></a></h3>
            <p class="meta"><?= date('F j, Y',(($event->time / 1000) + 3600)); ?> @ <?= date('g:i a',(($event->time / 1000)+3600)); ?> | <?= $event->yes_rsvp_count; ?> going.</p>
            <p><?= linkify($event->description); ?></p>
            <p><a href="<?= $event->event_url; ?>" target="_blank">Join this event</a></p>
        </article>
        <?
    }
```
