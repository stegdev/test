<?php
/**
 * Created by IntelliJ IDEA.
 * User: razal
 * Date: 22.10.2018
 * Time: 22:00
 */
/*Variables part*/
class BetsStructure{
    public $id;
    public $bet;
    public $onWhom;
}
class CoefficientStructure{
    public $id;
    public $coefOfLeft;
    public $coefOfRight;
    public $coefOfDraw;
    public $winner;
}
$numberOfBets = 0;// Number of user's bets
$playerBalance = 0;// Balance of the player
$games = Array();// array with information about games
$numberOfGames = 0; //Number contains count of games that user wants play
$coefficientsOfGames = Array(); // Array with information about games' coefficients
$prize = 0;// Player's prize
$finalPrize = 0; // player's final prize
/*Code part*/
echo "Enter the number of bets below: ";
fscanf(STDIN,"%i\n",$numberOfBets);
if($numberOfBets <= pow(10,4)) {
    for ($counter = 0; $counter < $numberOfBets; $counter++) {
        try {
            echo "Enter the bet below: ";
            $line = trim(fgets(STDIN));
            $splittedLine = explode(" ", $line);
            $tempBetStructure = new BetsStructure();
            $tempBetStructure->id = $splittedLine[0];
            $tempBetStructure->bet = $splittedLine[1];
            if($tempBetStructure->id <= pow(10,5) && $tempBetStructure->id>=1 && $tempBetStructure->bet <=1000) {
                $tempBetStructure->onWhom = $splittedLine[2];
                $playerBalance+=$tempBetStructure->bet;
                $games[] = $tempBetStructure;
            }
            else{
                echo "Bet's id or bet's rate bigger than certain conditions. php script will be stopped";
                exit();
            }
        } catch (Exception $e) {
            echo "Something went wrong in process of bets' parsing";
            echo "$e";
        }
    }
}
else{
    echo "Number of bets is bigger than 10^4, php script will be stopped now.";
    exit();
}
array_reverse($games);
echo "Enter the number of coefficients below : ";
fscanf(STDIN,"%i\n",$numberOfGames);
if($numberOfGames>=$numberOfBets && $numberOfGames<=pow(10,5)){
    for ($counter = 0; $counter < $numberOfGames; $counter++) {
        try {
            echo "Enter the bet below: ";
            $line = trim(fgets(STDIN));
            $splittedLine = explode(" ", $line);
            $tempCoefStructure = new CoefficientStructure();
            if($splittedLine[0]>=1 && $splittedLine[0]<=pow(10,5)){
                $tempCoefStructure->id = $splittedLine[0];
                for($counterOfSplitted =1; $counterOfSplitted<count($splittedLine)-1;$counterOfSplitted++){
                    if($splittedLine[$counterOfSplitted]<=1 || $splittedLine[$counterOfSplitted]>=100){
                        echo "One parametr is bigger than conditions";
                        exit();
                    }
                }
                $tempCoefStructure->coefOfLeft = $splittedLine[1];
                $tempCoefStructure->coefOfRight = $splittedLine[2];
                $tempCoefStructure->coefOfDraw = $splittedLine[3];
                $tempCoefStructure->winner = $splittedLine[4];
                $coefficientsOfGames[] = $tempCoefStructure;
            }
            else{
                echo "Id of game is bigger than conditions.";
                exit();
            }
        } catch (Exception $e) {
            echo "Something went wrong in process of games' parsing";
            echo "$e";
        }
    }
}
echo "Let's start the games\n";
foreach($games as &$value){
  $elemnt = null;
  foreach($coefficientsOfGames as &$gameCoef){
    if($gameCoef->id == $value->id){
      $element = $gameCoef;
      break;
    }
  }
if($element!=null) {
        if ($element->id == $value->id) {
            if ($element->winner == $value->onWhom) {
                switch (strtoupper($element->winner)) {
                    case "L":
                        $prize += $value->bet * $element->coefOfLeft;
                        break;
                    case "R":
                        $prize += $value->bet * $element->coefOfRight;
                        break;
                    case "D":
                        $prize += $value->bet * $element->coefOfDraw;
                        break;
                }
            }
        }
    }
    else{
        echo "coef is null";
        exit();
    }
}
$finalPrize = ($playerBalance - $prize)*-1;
echo "Plyaer's prize is $finalPrize";
?>
