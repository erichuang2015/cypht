<?php


class Hm_Test_Webdav_Formats extends PHPUnit_Framework_TestCase {

    public function setUp() {
        require 'bootstrap.php';
    }
    /**
     * @preserveGlobalState disabled
     * @runInSeparateProcess
     */
    public function test_import_vcard_bad_prop() {
        $parser = new Hm_VCard();
        $this->assertFalse($parser->import("FOO\nFOO\nFOO\nFOO\n"));
        $card = "BEGIN:VCARD\nVERSION:4.0\nFOO:BAR\nEND:VCARD\n";
        $this->assertTrue($parser->import($card));
        $this->assertFalse(array_key_exists('foo', array_keys($parser->parsed_data())));
    }
    /**
     * @preserveGlobalState disabled
     * @runInSeparateProcess
     */
    public function test_import_vcard_bad_param() {
        $parser = new Hm_VCard();
        $card = "BEGIN:VCARD\nVERSION:4.0\nFOO;WTF=NO:BAR\nEND:VCARD\n";
        $this->assertTrue($parser->import($card));
        $this->assertFalse(array_key_exists('foo', array_keys($parser->parsed_data())));
    }
    /**
     * @preserveGlobalState disabled
     * @runInSeparateProcess
     */
    public function test_import_vcard_failed() {
        $parser = new Hm_VCard();
        $card = "BEGIN:VCARD\nFOO\n";
        $this->assertFalse($parser->import($card));
    }
    /**
     * @preserveGlobalState disabled
     * @runInSeparateProcess
     */
    public function test_import_vcard() {
        $parser = new Hm_VCard();
$card = 'BEGIN:VCARD
VERSION:4.0
N:Gump;Forrest;;Mr.;
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;MEDIATYPE=image/gif:http://www.example.com/dir_photos/my_photo.gif
TEL;TYPE=work,voice;VALUE=uri:tel:+1-111-555-1212
TEL;TYPE=home,voice;VALUE=uri:tel:+1-404-555-1212
ADR;TYPE=WORK;PREF=1;LABEL="100 Waters Edge\nBaytown\, LA 30314\nUnited States of America":;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR:;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR;TYPE=HOME;LABEL="42 Plantation St.\nBaytown\, LA 30314\nUnited States of America":;;42 Plantation St.;Baytown;LA;30314;United States of America
EMAIL:forrestgump@example.com
REV:20080424T195243Z
x-qq:21588891
END:VCARD';
        $this->assertTrue($parser->import($card));
        //print_r($parser->parsed_data());
        $this->assertEquals(13, count($parser->parsed_data()));
    }
    /**
     * @preserveGlobalState disabled
     * @runInSeparateProcess
     */
    public function test_import_ical() {
        $parser = new Hm_ICal();
$card = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//ABC Corporation//NONSGML My Product//EN
BEGIN:VTODO
DTSTAMP:19980130T134500Z
SEQUENCE:2
UID:uid4@example.com
DUE:19980415T235959
STATUS:NEEDS-ACTION
SUMMARY:Submit Income Taxes
BEGIN:VALARM
ACTION:AUDIO
TRIGGER:19980414T120000
ATTACH;FMTTYPE=audio/basic:http://example.com/pub/audio-
 files/ssbanner.aud
REPEAT:4
DURATION:PT1H
END:VALARM
END:VTODO
END:VCALENDAR';
        $this->assertTrue($parser->import($card));
        //print_r($parser->parsed_data());
        $this->assertEquals(15, count($parser->parsed_data()));
    }
}
?>
