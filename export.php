<?
	// For documentation on how to work with fpdf and how to
	// change the format of this report, please refer to:
	// http://www.fpdf.org/en/doc/index.php
	// - David

	include("config.php");
	require("php/fpdf.php");

		$database="lingStudyDB";
		$server="localhost";
		$db_user="max";
		$db_pass="fish123";
		$table="testGame";
		$id="playerID";
		$sessID = $_GET["sessID"];

		$link=mysql_connect($server,$db_user,$db_pass);
		mysql_select_db($database,$link);

	// Converts a FEN string to an ASCII representation
	function convertFenToAscii($fen){
		$asciiRow = "+".str_repeat("-",31)."+\n";
		$asciiRow .= "|";

		for($i = 0; $i < strlen($fen); $i++){
			if(is_numeric($fen[$i])){
				$spaceNum = ord($fen[$i]) - 48;
				$asciiRow .= str_repeat("   |", $spaceNum);
			} else {
				switch($fen[$i]) {
					case '/':
						$asciiRow .= "\n|";
						break;
					default:
						$asciiRow .= " ".$fen[$i]." |";
				}
			}
		}
		$asciiRow .= "\n+".str_repeat("-",31)."+\n";
		return $asciiRow;
	}

	$pdf = new FPDF();

	$pdf->SetFont('Arial', 'I', 16);

	$query = "SELECT * FROM `testGame` WHERE `sessID` = '$sessID';";
	$query2 = "SELECT `trans` from `testers` WHERE `sessID` = '".$sessID."';";

	$result = mysql_query($query);
	$transcript = mysql_fetch_array(mysql_query($query2));

	$players = array();

	array_push($players,'A');
	array_push($players,'B');
	array_push($players,'C');
	array_push($players,'D');
	array_push($players,'E');
	array_push($players,'F');	

	$player = 0;
	$i = 40;

	if(!empty($transcript[0])){
		$pdf->AddPage();
		$pdf->Write(6,"Audio / Transcription Data for Session #".$sessID."\n\n\n");
		$pdf->SetFont('Arial', '', 12);
		$pdf->Write(6,utf8_decode($transcript[0]));
	}

	$pdf->SetFont('Arial', 'I', 16);

	while($newRow = mysql_fetch_array($result)) {
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'I', 16);
		$pdf->Cell(0,10,'Board History For Session #'.$sessID." ".$players[$player],1,1,'C');
		$pdf->SetFont('Arial', '', 15);

		$boardHist = explode("|", $newRow[2]);

		$pdf->AddFont('terminal','','TerminusTTF-4.39.php');
		$pdf->Write(4,"\n");	
		$pdf->SetFont('terminal', '', 8);
		for($k = 0; $k < sizeof($boardHist); $k++){
			$asciiRow = convertFenToAscii($boardHist[$k]);
			$pdf->Write(3,"Move ".($k+1).":\n".$asciiRow);
			$i += 15;
		}
		
		$pdf->SetFont('Arial', 'B', 16);
		$i = 40;
		$player++;
	}

	$pdf->Output();
?>
