<?php

$outputPath = 'tests/_output/';
$outputFile = 'trustChain.crt';
$outputResult = $outputPath.$outputFile;

if (file_exists($outputResult)) {
    unlink($outputResult);
}

$command = 'php ./ssl-certificate-chain-resolver resolve tests/_data/google.crt '.$outputResult;

$I = new FunctionalTester($scenario);
$I->wantTo('download intermediate certificates and write them to a file');

$I->runShellCommand($command);

$I->seeFileFound($outputFile, $outputPath);

$expected = file_get_contents('tests/_data/expectedTrustChain.crt');
$output = file_get_contents($outputResult);

$expected = str_replace("\r", '', $expected);
$output = str_replace("\r", '', $output);

PHPUnit_Framework_Assert::assertEquals($expected, $output);
