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
        echo ' class="' . $node['class'] . ' node-element border-2 p-2"';
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

        $totalAnswerInputs = count($node['answerInputs']);
        $counterAnswerInputs = 0;

        foreach ($node['answerInputs'] as $answer) {
            renderAnswer($answer, $radioTemplates);

            $counterAnswerInputs++; // Increment counter on every loop

            // Only echo the div if this is not the last item
            if ($counterAnswerInputs < $totalAnswerInputs) { 
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

            $isFirst = true;

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
                            value="' . $choice['value'] . '" ';
                
                if ($isFirst && $answer['required'] == "true") {
                    // Do something special for the first item
                    $isFirst = false; // Turn it off immediately

                    echo 'required';
                }

                echo '>';

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
                        step="' . $answer['step'] . '" ';
            
            if ($answer['required'] == "true") {
                echo 'required';
            }

            echo '>';

            if (!empty($answer['suffix'])) {
                echo '<label class="ml-2" for="' . $id . '">' . $answer['suffix'] . '</label>';
            }

            if ($answer['required'] == "true") {
                echo '<label style="color: red;">*</label>';
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
            
            if ($answer['required'] == "true") {
                echo '<label style="color: red;">*</label>';
            }

            echo '<input
                        type="text"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '"
                        maxlength="' . $answer['maxlength'] . '" ';
            
            if ($answer['required'] == "true") {
                // Do something special for the first item
                echo 'required';
            }

            echo '>';

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

            if ($answer['required'] == "true") {
                echo '<label style="color: red;">*</label>';
            }

            echo '<input
                        type="date"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '" ';

            if ($answer['required'] == "true") {
                // Do something special for the first item
                echo 'required';
            }

            echo '>';

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

            if ($answer['required'] == "true") {
                echo '<label style="color: red;">*</label>';
            }

            echo '<input
                        type="month"
                        class="form-control mb-2"
                        id="' . $id . '"
                        name="' . $answer['name'] . '" ';
            
            if ($answer['required'] == "true") {
                // Do something special for the first item
                echo 'required';
            }

            echo '>';

            echo '
                </div>
            </div>';

            break;
        case 'hidden':
            $id = $answer['name'];

            echo '<input
                        type="hidden"
                        id="' . $id . '"
                        name="' . $answer['name'] . '"
                        value="' . $answer['value'] . '">';

            break;
    }
}

$document_no = isset($_GET['document_no']) ? $_GET['document_no'] : '';

if (empty($document_no)) {
    $conn = null;
    exit("Must have document no to display checksheet form");
}

// Get checksheet template json
$sql = "EXEC chksht_GET_trd_latest :documentNo";

$stmt = $conn->prepare($sql);

$stmt->bindValue(':documentNo', trim($document_no), PDO::PARAM_STR);

$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $conn = NULL;
    exit("No Checksheet Template Found! Call IT Personnel Immediately!!!");
}

$data = json_decode($row['document_json'], true);

$radioTemplates = $data['radioTemplate'];

// Checksheet ID generation
echo '<input type="hidden" id="checksheet_id" name="checksheet_id" value="' . str_replace('.', '', uniqid('MIR-', true)) . '">';

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

$conn = NULL;
