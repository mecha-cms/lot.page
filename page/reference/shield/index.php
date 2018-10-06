<?php

Hook::set('*.content', function($content, $lot) {
    if (!isset($lot['path']) || strpos($lot['path'], PAGE) !== 0) {
        return $content;
    }
    $N = isset($lot['name']) ? $lot['name'] : Path::N($lot['path']);
    $NS = 'shield';
    $stats = include ROOT . DS . 'stats.php';
    $releases = include ROOT . DS . 'releases.php';
    $i = 'https://github.com/mecha-cms/' . $NS . '.' . $N . '/archive/master.zip';
    $i = isset($stats[$i]) ? $stats[$i] : 0;
    $j = 0;
    $k = basename(str_replace('.', '/', $NS));
    if (!empty($r = get_github_release_latest('mecha-cms/' . $NS . '.' . $N))) {
        $j = 'https://github.com/mecha-cms/' . $NS . '.' . $N . '/archive/' . $r . '.zip';
        $j = isset($stats[$i]) ? $stats[$i] : 0;
    }
    // $i += $j;
    if (!isset($lot['dependency']) || $lot['dependency'] !== false) {
        $s = "";
        if (!empty($r)) {
            $s .= '[Download Version ' . substr($r, 1) . '](http://127.0.0.1/r/git:mecha-cms/' . $NS . '.' . $N . '/archive/' . $r . '.zip "' . $j . ' Downloads") {.button} ';
        }
        $s .= '[Download Development Version](http://127.0.0.1/r/git:mecha-cms/' . $NS . '.' . $N . '/archive/master.zip "' . $i . ' Downloads") {.button}';
        $content = $s . N . N . $content;
    }
    if (!empty($lot['dependency']) && $lot['dependency'] !== true) {
        $content .= N . N . '### Dependency';
        if (!empty($lot['dependency']['extension'])) {
            $content .= N . N . '#### Extension' . N;
            foreach ($lot['dependency']['extension'] as $v) {
                $content .= N . ' - [link:/reference/extension/' . str_replace('.', '-', $v) . ']';
            }
        }
        if (!empty($lot['dependency']['plugin'])) {
            $content .= N . N . '#### Plugin' . N;
            foreach ($lot['dependency']['plugin'] as $v) {
                $content .= N . ' - [link:/reference/extension/plugin/' . str_replace('.', '-', $v) . ']';
            }
        }
    }
    if (!empty($lot['dependency_x'])) {
        $content .= N . N . '### Conflict With';
        if (!empty($lot['dependency_x']['extension'])) {
            $content .= N . N . '#### Extension' . N;
            foreach ($lot['dependency_x']['extension'] as $v) {
                $content .= N . ' - [link:/reference/extension/' . str_replace('.', '-', $v) . ']';
            }
        }
        if (!empty($lot['dependency_x']['plugin'])) {
            $content .= N . N . '#### Plugin' . N;
            foreach ($lot['dependency_x']['plugin'] as $v) {
                $content .= N . ' - [link:/reference/extension/plugin/' . str_replace('.', '-', $v) . ']';
            }
        }
    }
    return $content;
}, .9);