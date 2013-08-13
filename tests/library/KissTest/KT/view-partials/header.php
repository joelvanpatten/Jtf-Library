
<?php /* @var $summary KT_Result_Summary */ ?>

<?php

$sumarry_result_status = 'FAIL';
$result_class = 'test-fail';

if(!$summary->getTestCasesFailedCount())
{
    $sumarry_result_status = 'PASS';
    $result_class = 'test-pass';
}

?>

<div id="header" class="<?php echo $result_class; ?>">
    <div id="overall-test-results">
        Test Results: <?php echo $sumarry_result_status; ?>
    </div>

    <div id="overall-total-tests" class="center">
        Total: <?php echo $summary->getTestCasesCount(); ?><br />
        (<?php printf("%.2f", $summary->getExecutionTimeInMillisecs()); ?> mSecs)
    </div>
    <div id="overall-tests-failed" class="center">
        Tests Failed: <?php echo $summary->getTestCasesFailedCount(); ?> <br />
        (<?php printf("%.2f", $summary->getPercentageFailed()); ?>%)
    </div>
    <div id="overall-tests-passed" class="center">
        Tests Passed: <?php echo $summary->getTestCasesPassedCount(); ?><br />
        (<?php printf("%.2f", $summary->getPercentagePassed()); ?>%)
    </div>
    <br style="clear:both" />
</div> <!-- header -->
