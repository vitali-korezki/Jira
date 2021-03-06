<?php

usort($worklogs, function($a, $b) {
	$diff = strtotime($a->started) - strtotime($b->started);
	if (!$diff) {
		$diff = strtotime($a->created) - strtotime($b->created);
	}
	return $diff;
});

$table = '';
$table .= '<div class="table worklogs striping">';
if ( !empty($filterDate) || !empty($filterUser) ) {
	$header = array();
	empty($filterDate) or $header[] = date(FORMAT_DATE, strtotime($filterDate));
	empty($filterUser) or $header[] = html($filterUser);

	$table .= '<h2>' . implode(' - ', $header) . '</h2>';
}

$perUser = array();

$table .= '<table>';
$minutes = 0;
$lastDate = null;
foreach ( $worklogs AS $worklog ) {
	$minutes += $worklog->timeSpentSeconds / 60;
	$started = strtotime($worklog->started);
	$created = strtotime($worklog->created);
	$ymdDate = date('Y-m-d', $started);

	@$perUser[$worklog->author->name] += $worklog->timeSpentSeconds / 60;

	$dateMatch = empty($filterDate) || $filterDate == $ymdDate;
	$userMatch = empty($filterUser) || $filterUser == $worklog->author->name;

	if ( $dateMatch && $userMatch ) {
		$newSection = $lastDate != $ymdDate ? 'new-section' : '';

		$table .= '<tr class="' . $newSection . '">';
		$table .= '<td title="Created: ' . date(FORMAT_DATETIME, $created) . '">' . date(FORMAT_DATE, $started) . '</td>';
		$table .= '<td>' . do_time($worklog->timeSpentSeconds / 60) . '</td>';
		$table .= '<td>' . html(@$worklog->author->displayName ?: @$worklog->author->name ?: '??') . '</td>';
		$table .= '<td>' . html(@$worklog->comment ?: '') . '</td>';
		$table .= '<td class="actions">';
		$table .= '  <a href="logwork.php?key=' . $key . '&summary=' . urlencode($summary) . '&id=' . $worklog->id . '">e</a> |';
		$table .= '  <a class="ajax" data-confirm="DELETE this WORKLOG forever and ever?" href="issue.php?key=' . $key . '&delete_worklog=' . $worklog->id . '&token=' . XSRF_TOKEN . '">x</a>';
		$table .= '</td>';
		$table .= '</tr>';
	}

	$lastDate = $ymdDate;
}
$table .= '</table>';
$table .= '</div>';

arsort($perUser);

$userTable = '';
if (count($perUser) > 1) {
	$userTable .= '<div class="table worklogs striping">';
	$userTable .= '<table>';
	foreach ($perUser as $username => $userMinutes) {
		$userTable .= '<tr class="new-section">';
		$userTable .= '<td>' . html($username ?: '??') . '</td>';
		$userTable .= '<td>' . do_time($userMinutes) . '</td>';
		$userTable .= '</tr>';
	}
	$userTable .= '</table>';
	$userTable .= '</div>';
	$userTable .= '<br />';
}

echo '<p>' . do_time($minutes) . ' spent on this issue.</p>';

echo "$userTable $table";
