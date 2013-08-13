<?php /* @var $result KT_Result_UnitTest */ ?>
<?php /* @var $current KT_Result_TestCase */ ?>
<?php

$testCaseResults = $result->getTestCaseResults();
$current = $testCaseResults[$i];

?>
<?php if(!$current->getTestStatus()): ?>

<tr class="test-case-line-item">
    <td  class="test-case-line-item-number">
        <?php echo ($i + 1) ?>.
    </td>
     <td>
         <div class="test-case-line-item-name test-fail">
            <?php echo $current->getTestCaseName(); ?><br />
            &nbsp;&nbsp;&nbsp;<span style="font-size:12px"><?php echo $current->getMessage(); ?></span>
         </div>
    </td>
    <td>
        <div class="test-case-line-item-time center test-fail">
            (<?php printf("%.2f", $current->getExecutionTimeInMillisecs()); ?>mSecs)<br />
            &nbsp;
        </div>
    </td>
</tr>

<?php else: ?>

<tr class="test-case-line-item">
    <td  class="test-case-line-item-number">
        <?php echo ($i + 1) ?>.
    </td>
     <td>
         <div class="test-case-line-item-name test-pass">
            <?php echo $current->getTestCaseName(); ?>
         </div>
    </td>
    <td>
        <div class="test-case-line-item-time center test-pass">
            (<?php printf("%.2f", $current->getExecutionTimeInMillisecs()); ?>mSecs)
        </div>
    </td>
</tr>

<?php endif; ?>