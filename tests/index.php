<?php
require_once('config/main.php');
KissUnitTest::startTimer();

new Jtf_AbstractEntityTests();
new Jtf_AbstractJoinTableGatewayTests();
new Jtf_AbstractTableGatewayTests();
new Jtf_AgentTests();
new Jtf_ArrayTests();
new Jtf_AsciiTests();
new Jtf_BcryptTests();
new Jtf_BigIntTests();
new Jtf_ChronographTests();
new Jtf_CsrfGuardTests();
new Jtf_DecimalTests();
new Jtf_Enum_DaysTests();
new Jtf_Enum_MonthsTests();
new Jtf_HttpCodesTests();
new Jtf_MimeTypeTests();
new Jtf_OptionalTests();
new Jtf_PageRedirectTests();
new Jtf_SessionTests();
new Jtf_SecurityTests();
new Jtf_StringUtilitiesTests();
new Jtf_UrlTests();

KissUnitTest::getAllUnitTestsSummary();