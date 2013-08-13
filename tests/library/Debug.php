<?php
/**
 * This class provides functionality to allow the debugging of PHP applications
 * using JavaScript based popup windows. Furthermore, this prevents debug
 * statements from altering the normal layout of a page.
 *
 * @author      Joseph Fallon <joseph.t.fallon@gmail.com>
 * @copyright   Copyright (c) 2010, Joseph Fallon
 */
class Debug
{
    /**
     * @var bool Window Is Open
     */
    private static $windowIsOpen;

    /**
     * This function opens a debugging window if it is not already open.
     * 
     * @return null
     */
    private static function openDebugWindow()
    {
        date_default_timezone_set('America/Anchorage');
        
        if(!isset (self::$windowIsOpen) || !self::$windowIsOpen)
        {
            
            ?>

<script type="text/javascript">
    debugWindow = window.open("","debugWindow","toolbar=no,scrollbars,width=800,height=500");
    debugWindow.document.getElementsByTagName('body')[0].innerHTML = '';
    debugWindow.document.writeln('<html>');
    debugWindow.document.writeln('<head>');
    debugWindow.document.write('<title>Debug Window - Request Time: ');
    debugWindow.document.write('<?php echo date('Y-m-d H:i:s', $_SERVER["REQUEST_TIME"]); ?>');
    debugWindow.document.writeln('</title>');
    debugWindow.document.writeln('</head>');
    debugWindow.document.writeln('<body>');
</script>

            <?php

            self::$windowIsOpen = TRUE;
        }
    }


    /**
     * This function dumps the variable contents to the debugging window.
     *
     * @param   strng   $name   Name of Varaible
     * @param   mixed   $data   Data to Dump
     * @return  null
     */
    public static function dump($name, $data = "")
    {
        self::openDebugWindow();

        $data = print_r($data, TRUE);
        $data = explode("\n", $data);
        ?>

<script type="text/javascript">
    debugWindow.document.writeln('<hr size=1 width="100%">');
    debugWindow.document.writeln('<b><?php echo $name; ?></b><br />');
    debugWindow.document.writeln('<pre>');

        <?php

        foreach ($data as $key=>$value)
        {
            $value = str_replace("\n",'',addslashes($value));
			$value = str_replace("\r",'',$value);
        ?>

    debugWindow.document.writeln('<?php echo $value; ?>');

        <?php
        }
        ?>

    debugWindow.document.writeln('</pre>');
</script>

    <?php
    }


    /**
     * This function prints a debugging message to the debugging window.
     *
     * @param   string  $message    Message to Print
     */
    public static function log($message)
    {
        $message = str_replace("\n",'',addslashes(trim(nl2br($message))));
    
        self::openDebugWindow();

        echo "<script language='JavaScript'>\n";
        echo "\tdebugWindow.document.writeln('<hr size=1 width=\"100%\">');";
        echo "\tdebugWindow.document.writeln('<p style=\'font-size:13px;\'>";
        echo "\t" . str_replace("\r", '', $message) . "</p>');\n";
        echo "</script>\n";
    }
}