<?php
// Phrase à retourner
function askUser()
{
    return readline("Entrez le nom à rechercher : ");
}

function searchInArray($json_file, $search_value)
{
    foreach ($json_file as $key => $json_line) {
        if ($json_line['name'] === $search_value) {
            return $key;
            break;
        }
    }
}

function displayError($msg)
{
    echo $msg;
    exit;
}

function rechercheBinaire(array $arr, $start, $end, $x, $step = 0)
{
    $step++;
    if ($end < $start)
        return json_encode([
            'success' => false
        ]);
    $mid = floor(($end + $start) / 2);
    if ($arr[$mid]["name"] == $x)
        return json_encode([
            'success' => true,
            'numero' => $arr[$mid]['num'],
            'position' => $mid,
            'step' => $step
        ]);
    elseif ($arr[$mid]["name"] > $x)
        return rechercheBinaire($arr, $start, $mid - 1, $x, $step);
    else
        return rechercheBinaire($arr, $mid + 1, $end, $x, $step);
}
$json_file = file_get_contents('annuaire.json');
$json_file = json_decode($json_file, true);

$search_value = askUser();

$datas = json_decode(rechercheBinaire($json_file, 0, count($json_file) - 1, $search_value));

if ($datas->success == true)
    echo 'Entrée trouvée : '
        . PHP_EOL .
        ' => Numéro : ' . $datas->numero
        . PHP_EOL .
        ' => Position : ' . $datas->position
        . PHP_EOL .
        ' => Étapes : ' . $datas->step;
else echo displayError('Aucune entrée trouvée avec ce terme de recherche');
