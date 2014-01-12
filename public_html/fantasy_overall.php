<?php
	$playerWins = array();
	$playerLoses = array();
	foreach(Helpers::$weeks as $weekId) {
		if ($weekId == WeeklyStats::currentWeekId()) break;
		$fantasyStats = FantasyStats::createForWeek(WeeklyStats::loadByWeekID($weekId));
		$weekMatches = MongoHelper::getWeekFantasyMatches($weekId);
		foreach($weekMatches->getMatches() as $match) {
			$player1Stats = $fantasyStats->getForPlayer($match['player1']);
			$player2Stats = $fantasyStats->getForPlayer($match['player2']);
			if ($player1Stats->getRatio() > $player2Stats->getRatio()) {
				if (!isset($playerWins[$match['player1']])) {
					$playerWins[$match['player1']] = 0;
				}
				if (!isset($playerLoses[$match['player2']])) {
					$playerLoses[$match['player2']] = 0;
				}
				$playerWins[$match['player1']] += 1;
				$playerLoses[$match['player2']] += 2;
				
			} elseif ($player1Stats->getRatio() < $player2Stats->getRatio()) {
				if (!isset($playerWins[$match['player2']])) {
					$playerWins[$match['player2']] = 0;
				}
				if (!isset($playerLoses[$match['player1']])) {
					$playerLoses[$match['player1']] = 0;
				}
				
				$playerWins[$match['player2']] += 1;
				$playerLoses[$match['player1']] += 1;
			}
		}	
	}	
print_r($playerLoses);
?>
<table>
	<?php foreach($playerWins as $key=>$value): ?>
		<tr>	
			<td><?php echo $key; ?></td>
			<td><?php echo $value; ?> </td>
			<td><?php echo $playerLoses[$key]; ?> </td>
		</tr>
	<?php endforeach ?>
</table>
