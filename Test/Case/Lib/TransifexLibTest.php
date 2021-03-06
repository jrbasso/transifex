<?php
App::uses('TransifexLib', 'Transifex.Lib');
App::uses('MyCakeTestCase', 'Tools.TestSuite');

/**
 *
 */
class TransifexLibTest extends MyCakeTestCase {

	public $Transifex = null;

	public function setUp() {
		parent::setUp();

		$settings = array(
			'project' => 'cakephp',
		);
		$this->Transifex = new TransifexLib($settings);
	}

	public function testGetProject() {
		$res = $this->Transifex->getProject();
		//debug($res);
		$this->assertEquals('en', $res['source_language_code']);
		$this->assertEquals('http://cakephp.org/', $res['homepage']);
		$this->assertSame(false, $res['private']);

		// languages
		$this->assertTrue(!empty($res['teams']));

		$this->assertTrue(!empty($res['maintainers']));
		$this->assertTrue(!empty($res['resources']));
	}

	public function testGetResources() {
		$res = $this->Transifex->getResources();
		//debug($res);
		$this->assertTrue(count($res) > 2);
		$this->assertTrue(!empty($res[0]['i18n_type']));
	}

	public function testGetResource() {
		$res = $this->Transifex->getResource('cake');
		//debug($res);
		$this->assertEquals('PO', $res['i18n_type']);
		$this->assertEquals('en', $res['source_language_code']);
	}

	public function _testGetLanguages() {
		$res = $this->Transifex->getLanguages();
		debug($res);
	}

	public function _testGetLanguage() {
		$res = $this->Transifex->getLanguage('de');
		debug($res);
	}

	public function testGetTranslations() {
		$res = $this->Transifex->getTranslations('cake', 'de');
		//debug($res);
		$this->assertEquals('text/x-po', $res['mimetype']);
		$this->assertTextContains('Plural-Forms: nplurals=2; plural=(n != 1);', $res['content']);
	}

	public function testGetStats() {
		$res = $this->Transifex->getStats('cake');
		//debug($res);
		$this->assertTrue(count($res) > 6);
		$this->assertTrue(!empty($res['de']['reviewed_percentage']));

		$res = $this->Transifex->getStats('cake', 'de');
		$this->assertTrue(!empty($res['reviewed_percentage']));
	}

}
