<?php

echo '<hr>';

foreach ( $issues->issues AS $issue ) {
	$fields = $issue->fields;

	$resolution = '';
	if ( $fields->resolution ) {
		$resolution = ': ' . $fields->resolution->name;
	}

	$status = $fields->resolution ? $fields->resolution->name : $fields->status->name;

	$created = strtotime($fields->created);
	$updated = strtotime($fields->updated);

	echo '<h2><a href="issue.php?key=' . $issue->key . '">' . $issue->key . ' ' . $fields->summary . '</a></h2>';
	echo '<p class="short-meta">';
	echo '	<span class="left"><img src="' . $fields->issuetype->iconUrl . '" alt="' . $fields->issuetype->name . '" /> ' . $fields->issuetype->name . '</span>';
	echo '	<span class="center">' . ( $fields->priority ? '<img src="' . $fields->priority->iconUrl . '" alt="' . $fields->priority->name . '" /> ' . $fields->priority->name : '&nbsp;' ) . '</span>';
	echo '	<span class="right"><strong>' . $status . '</strong></span>';
	echo '</p>';
	if ( $fields->labels ) {
		echo '<p class="labels">Labels: <span class="label">' . implode('</span> <span class="label">', $fields->labels) . '</span></p>';
	}
	echo '<p class="dates">';
	echo '	<span class="left">' . date(FORMAT_DATETIME, $created) . '</span>';
	echo '	<span class="right">' . date(FORMAT_DATETIME, $updated) . '</span>';
	echo '</p>';

	echo '<hr>';
}

?>

<p id="pager">
	<a href="?<?= html_q(array('page' => $page-1)) ?>">&lt; prev</a> |
	<span><?= $page+1 ?> / <?= ceil($issues->total/$perPage) ?> (<?= $issues->total ?>)</span> |
	<a href="?<?= html_q(array('page' => $page+1)) ?>">next &gt;</a>
</p>

<script>
$('#pager').find('a').on('click', function(e) {
	e.preventDefault();
	$.get(this.href + '&ajax=1', function(t) {
		$('#content').html(t);
	});
});
</script>