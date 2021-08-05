<?php
// -------------------------------------------------------------
// Elohim.net - Help admin page
// -------------------------------------------------------------
?>

<head>
    <style type = text/css>
        .boulette1 {list-style-type: disc; padding-left: 40px}
        .boulette2 {list-style-type: circle; padding-left: 40px}
    </style>
</head>

<h1>Elohim.net plugin - Help</h1>
<p>This plugin allows to import in raelcanada, raelmexico or raelusa all emails related to the mailing lists that are in Elohim.net.</p>
<h2>Import rules</h2>
<p>An email is accepted if it meets the following rules:</p>
<ul class="boulette1">
    <li>Must be part of at least one mailing list on Elohim.net</li>
    <li>If the email is associated with a single list, this list should not be the 'International mailout' list</li>
    <li>The type associated with the email must be one of the following values:</li>
    <ul class="boulette2">
        <li><strong>M</strong>: Member</li>
        <li><strong>S</strong>: Structure</li>
        <li><strong>R</strong>: Raelian</li>
        <li><strong>P</strong>: Prospect</li>
        <li><strong>XM</strong>: Ex-Member</li>
        <li><strong>XR</strong>: Ex-Raelian</li>
        <li><strong>XS</strong>: Ex-Structure</li>
    </ul>
    <li>The status associated with the email must not be one of the following values:</li>
    <ul class="boulette2">
        <li>Email bounced</li>
        <li>Not interested</li>
    </ul>
</ul>
<h2>Settings page</h2>
<p>Description of the parameters:</p>
<ul class="boulette1">
    <li><strong>Country:</strong> This is the country for which you want to import the emails</li>
    <li><strong>Mailpoet list id:</strong> Emails are imported into a previously created Mailpoet list. The id of the list is obtained in the table 'WP_mailpoet_segments'. To be completed according to the country:</li>
    <ul class="boulette2">
        <li><strong>English</strong>: Canada and United-States</li>
        <li><strong>French</strong>: Canada only</li>
        <li><strong>Spanish</strong>: Mexico only</li>
    </ul>
    <li><strong>Deal with unsubscriptions:</strong> Used to synchronize in Mailpoet unsubscriptions occurring in Elohim.net since the last import. This setting is important and should stay at NO most of the time. Why? On Elohim.net, it is common for the IP address to fall into a blacklist when a massive campaign is sent. When this happens, several emails become temporarily unsubscribed in Elohim.net. These are false unsubscriptions that must not be synchronized in Mailpoet.</li>
    <li><strong>Send report to:</strong> Allows sending an import report to the responsible person.</li>
</ul>
<h2>Admin page</h2>
<p>Launch an import and display all imports with the following data.</p>
<p>Warning! Do not try to match numbers with each other. Some are accurate while others are approximate like bad emails.</p>
<ul class="boulette1">
    <li><strong>Id:</strong> Import Id</li>
    <li><strong>Date:</strong> Date of import</li>
    <li><strong>Imported:</strong> Total of emails imported that are associated with a mailing list</li>
    <li><strong>Valid:</strong> Number of emails that comply with the import rules.</li>
    <li><strong>New:</strong> Number of new emails since the last import</li>
    <li><strong>Unsubscribed:</strong> Number of emails unsubscribed in Elohim.net since the last import. If the 'Deal with unsubscriptions' option is YES, the email is unsubscribed also in Mailpoet.</li>
    <li><strong>Updated:</strong> Number of emails whose basic information to change since the last import (last name, first name, etc.)</li>
    <li><strong>Unsubscrivers to send to Elohim.net:</strong> Number of unsubscriptions or spam that occurred in Mailpoet which must be returned to Elohim.net for synchronization purposes.</li>
    <li><strong>Unsubscribed not applied in Elohim.net.:</strong> Number of unsubscriptions returned to Elohim.net that were not applied. An unsubscription is refused by Elohim.net when it comes to a member who is in the structures. Take note that some emails are subscribed again in Elohim.net even after having unsubscribed in Mailpoet. To respect the choice of the person, the email remains unsubscribed in Mailpoet.</li>
    <li><strong>Bounced, Invalid & Unsubscribed in Mailpoet: Unsubscribe in Mailpoet. </strong> It can be bad or invalid emails detected by www.datavalidation.com. It can also be bounced emails without good status or emails moved to one list to another. Note that this data is approximate.</li>
    <li><strong>Inactive in Mailpoet:</strong> If the 'Stop sending to inactive subscribers' option of Mailpoet is used, shows the number of emails that have been rendered inactive by Mailpoet after 6 months.</li>
    <li><strong>Subscribed in Mailpoet:</strong> Number of active emails in Mailpoet. Take note that this is a distinct count. If an email is in two lists, it is counted only once.</li>
</ul>
