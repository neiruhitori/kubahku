<?php
// Read the index.php file
$content = file_get_contents('index.php');

// Find the start of the portfolio section (a134299)
$start_marker = 'class="elementor-section elementor-inner-section elementor-element elementor-element-a134299';
$start_pos = strpos($content, $start_marker);

if ($start_pos === false) {
    die("Could not find start marker\n");
}

// Find the section opening tag before the marker
$section_start = strrpos($content, '<section', -strlen($content) + $start_pos - 500);
if ($section_start === false) {
    die("Could not find section opening\n");
}

// Find the end (closing </section> for this section, before dd5a777)
$dd5a777_pos = strpos($content, 'elementor-element-dd5a777');
if ($dd5a777_pos === false) {
    die("Could not find dd5a777 marker\n");
}

// Find the last </section> before dd5a777
$section_end = strrpos($content, '</section>', -strlen($content) + $dd5a777_pos);
$section_end += strlen('</section>');

// The PHP include to replace with
$include_code = "<?php include __DIR__ . '/application/views/home/portfolio_section.php'; ?>\n";

// Replace the entire section
$new_content = substr_replace($content, $include_code, $section_start, $section_end - $section_start);

// Write back
if (file_put_contents('index.php', $new_content)) {
    echo "✓ Portfolio section replaced with database-driven include\n";
    echo "Start position: $section_start\n";
    echo "End position: $section_end\n";
} else {
    die("Failed to write file\n");
}
