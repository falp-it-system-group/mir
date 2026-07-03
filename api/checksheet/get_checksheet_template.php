<?php
require '../common/db_connection.php';
function renderNode($node, $radioTemplates)
{
    $tag = $node['element'] ?? 'div';

    echo '<' . $tag;

    if (!empty($node['id'])) {
        echo ' id="' . $node['id'] . '"';
    }

    if (!empty($node['class'])) {
        echo ' class="' . $node['class'] . ' border-bottom border-2 p-2"';
    }

    echo '>';

    // Text node
    if (isset($node['text'])) {
        echo htmlspecialchars($node['text']);
    }

    // Child nodes
    if (!empty($node['children'])) {
        foreach ($node['children'] as $child) {
            renderNode($child, $radioTemplates);
        }
    }

    // Answer controls
    if (!empty($node['answerInputs'])) {

        echo '<div class="row">';

        foreach ($node['answerInputs'] as $answer) {
            renderAnswer($answer, $radioTemplates);
            if (count($node['answerInputs']) > 1) {
                echo '<div class="border-right border-2"></div>';
            }
        }

        echo '</div>';
    }

    echo '</' . $tag . '>';
}

function renderAnswer($answer, $radioTemplates)
{
    switch ($answer['type']) {

        case 'radio':

            foreach ($radioTemplates[$answer['radioTemplate']] as $choice) {

                $id = $answer['name'] . '_' . $choice['value'];

                echo '
                <div class="col">
                    <div class="form-group mb-0 d-flex flex-column align-items-center">
                        <label class="h1" for="' . $id . '">
                            ' . $choice['label'] . '
                        </label>
                        
                        <input
                            type="radio"
                            class="form-control form-control-sm mb-2"
                            id="' . $id . '"
                            name="' . $answer['name'] . '"
                            value="' . $choice['value'] . '">';

                echo '
                    </div>
                </div>';
            }

            break;

        case 'number':
            $id = $answer['name'];

            echo '
            <div class="col">
                <div class="form-group mb-0 d-flex flex-row align-items-center">
                    <input
                        type="number"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '"
                        step="' . $answer['step'] . '">';

            if (!empty($answer['suffix'])) {
                echo '<label class="ml-2" for="' . $id . '">' . $answer['suffix'] . '</label>';
            }

            echo '
                </div>
            </div>';

            break;

        case 'text':
            $id = $answer['name'];

            echo '
            <div class="col">
                <div class="form-group mb-0">';
            
            if (!empty($answer['label'])) {
                echo '<label>' . $answer['label'] . '</label>';
            }

            echo '<input
                        type="text"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '"
                        maxlength="' . $answer['maxlength'] . '">';

            echo '
                </div>
            </div>';

            break;
        
        case 'date':
            $id = $answer['name'];

            echo '
            <div class="col">
                <div class="form-group mb-0">';
            
            if (!empty($answer['label'])) {
                echo '<label>' . $answer['label'] . '</label>';
            }

            echo '<input
                        type="date"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '">';

            echo '
                </div>
            </div>';

            break;
        
        case 'month':
            $id = $answer['name'];

            echo '
            <div class="col">
                <div class="form-group mb-0">';
            
            if (!empty($answer['label'])) {
                echo '<label>' . $answer['label'] . '</label>';
            }

            echo '<input
                        type="month"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '">';

            echo '
                </div>
            </div>';

            break;
    }
}

// Get checksheet template json
$sql = "EXEC chksht_GET_trd_latest";

$stmt = $conn->prepare($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    exit("No Checksheet Template Found! Call IT Personnel Immediately!!!");
}

$data = json_decode($row['document_json'], true);

$radioTemplates = $data['radioTemplate'];

foreach ($data['document'] as $group) {
    renderNode($group, $radioTemplates);
}

foreach ($data['descriptions'] as $group) {
    renderNode($group, $radioTemplates);
}

renderNode($data['inspectionGroupsTitle'][0], $radioTemplates);

foreach ($data['inspectionGroups'] as $group) {
    renderNode($group, $radioTemplates);
}

renderNode($data['inspectionGroups2Title'][0], $radioTemplates);

foreach ($data['inspectionGroups2'] as $group) {
    renderNode($group, $radioTemplates);
}

renderNode($data['inspectionGroups3Title'][0], $radioTemplates);

foreach ($data['inspectionGroups3'] as $group) {
    renderNode($group, $radioTemplates);
}
