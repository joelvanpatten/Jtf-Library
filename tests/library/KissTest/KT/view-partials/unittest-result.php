<?php /* @var $result KT_Result_UnitTest */ ?>

<div class="test-case-results">
    <div class="test-case-name">
        <h3><?php echo $result->getUnitTestName(); ?></h3>
    </div>
    <div class="test-case-metrics">
        Tests Failed: <?php echo $result->getNumberTestCasesFailed(); ?> 
            (<?php printf("%.2f", $result->getPercentageFailed()); ?>%),
        Tests Passed: <?php echo $result->getNumberTestCasesPass(); ?> 
            (<?php printf("%.2f", $result->getPercentagePassed()); ?>%),
        Total: <?php echo $result->getTestCaseCount(); ?> 
            (<?php printf("%.2f", $result->getExecutionTimeInMillisecs()); ?> mSecs)
    </div>
    <table>

        <?php for($i = 0; $i < count($result->getTestCaseResults()); $i++): ?>

            <?php require(realpath(dirname(__FILE__) . '/test-case-result.php')); ?>

        <?php endfor; ?>

    </table>
    <br style="clear:both" />
</div> <!-- test-case-results -->