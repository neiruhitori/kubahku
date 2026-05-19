<?php
// This script helps identify where the portfolio section ends
// Run manually to check what we need to replace

$file_content = file_get_contents(__DIR__ . '/index.php');

// Find the start of elementor-shortcode
$search_pattern = '<div class="elementor-shortcode">';
$start_pos = strpos($file_content, $search_pattern);

if ($start_pos === false) {
    echo "Pattern not found!\n";
    exit;
}

// Count from this position
$line_num = substr_count($file_content, "\n", 0, $start_pos) + 1;
echo "Found '<div class=\"elementor-shortcode\">' at line: " . $line_num . "\n";

// Now find where elementor-17338 opens and closes
$start_search = $start_pos;
$elementor_17338_pos = strpos($file_content, 'data-elementor-id="17338"', $start_search);
if ($elementor_17338_pos !== false) {
    $line_num_17338 = substr_count($file_content, "\n", 0, $elementor_17338_pos) + 1;
    echo "Found 'data-elementor-id=\"17338\"' at line: " . $line_num_17338 . "\n";
}

// Find where the elementor-inner closes (should be near the end of portfolio)
$search_for_inner = 'class="elementor-inner"';
$inner_pos = strpos($file_content, $search_for_inner, $start_pos);
if ($inner_pos !== false) {
    // Find the closing </div> for this inner div
    // We need to count nested divs properly
    $after_inner = substr($file_content, $inner_pos);
    $div_count = 0;
    $pos_in_section = 0;
    $found_end = false;
    
    while ($pos_in_section < strlen($after_inner) && !$found_end) {
        $next_open = strpos($after_inner, '<div', $pos_in_section);
        $next_close = strpos($after_inner, '</div>', $pos_in_section);
        
        if ($next_close === false) {
            break;
        }
        
        if ($next_open !== false && $next_open < $next_close) {
            // Found another opening div
            $div_count++;
            $pos_in_section = $next_open + 1;
        } else {
            // Found closing div
            if ($div_count === 0) {
                // This closes the elementor-inner
                $end_pos = $inner_pos + $next_close + 6; // +6 for '</div>'
                $line_num_end = substr_count($file_content, "\n", 0, $end_pos) + 1;
                echo "Found closing </div> for elementor-inner at line: " . $line_num_end . "\n";
                echo "Total range: line $line_num to line $line_num_end\n";
                $found_end = true;
            } else {
                $div_count--;
                $pos_in_section = $next_close + 1;
            }
        }
    }
}

// Try to extract a sample of what we'll replace
$sample_start = $start_pos;
$sample_length = min(500, strlen($file_content) - $sample_start);
echo "\n=== Sample of section start ===\n";
echo substr($file_content, $sample_start, $sample_length);
echo "\n=== End Sample ===\n";
?>
