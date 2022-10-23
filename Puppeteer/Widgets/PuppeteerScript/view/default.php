<?php


echo json_encode($this->runScript(json_decode(UrlVar('json'))), JSON_PRETTY_PRINT);