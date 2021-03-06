<?php
namespace tests\units\Langchecker;

use atoum;
use Langchecker\Project as _Project;

require_once __DIR__ . '/../bootstrap.php';

class Project extends atoum\test
{
    public function getReferenceLocaleDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'en-GB'],
            [$sites[1], 'en-US'],
        ];
    }

    /**
     * @dataProvider getReferenceLocaleDP
     */
    public function testGetReferenceLocale($a, $b)
    {
        $obj = new _Project();
        $this
            ->string($obj->getReferenceLocale($a))
                ->isEqualTo($b);
    }

    public function getSupportedFilesDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], ['file1.lang', 'file2.lang']],
            [$sites[2], ['page.lang']],
        ];
    }

    /**
     * @dataProvider getSupportedFilesDP
     */
    public function testGetSupportedFiles($a, $b)
    {
        $obj = new _Project();
        $this
            ->array($obj->getSupportedFiles($a))
                ->isEqualTo($b);
    }

    public function getSupportedLocalesDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], '', [], ['en-US', 'fr']],
            [$sites[0], '', $langfiles_subsets, ['en-US', 'fr']],
            [$sites[0], 'file1.lang', $langfiles_subsets, ['fr']],
            [$sites[0], 'file2.lang', $langfiles_subsets, ['en-US', 'fr']],
            [$sites[1], 'missing.lang', $langfiles_subsets, ['de', 'en-US', 'fr']],
            [$sites[1], 'file3.lang', $langfiles_subsets, ['de', 'en-US', 'fr']],
        ];
    }

    /**
     * @dataProvider getSupportedLocalesDP
     */
    public function testGetSupportedLocales($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->array($obj->getSupportedLocales($a, $b, $c))
                ->isEqualTo($d);
    }

    public function isCriticalFileDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'file1.lang', 'en-US', true],
            [$sites[0], 'file2.lang', 'en-US', false],
            [$sites[0], 'file2.lang', 'fr', true],
            [$sites[1], 'file3.lang', 'en-US', false],
        ];
    }

    /**
     * @dataProvider isCriticalFileDP
     */
    public function testIsCriticalFile($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->boolean($obj->isCriticalFile($a, $b, $c))
                ->isEqualTo($d);
    }

    public function isObsoleteFileDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'file1.lang', 'all', false],
            [$sites[0], 'file1.lang', 'fr', true],
            [$sites[0], 'file2.lang', 'en-US', true],
            [$sites[0], 'file2.lang', 'all', true],
        ];
    }

    /**
     * @dataProvider isObsoleteFileDP
     */
    public function testIsObsoleteFile($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->boolean($obj->isObsoleteFile($a, $b, $c))
                ->isEqualTo($d);
    }

    public function getFileFlagsDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'file1.lang', 'en-US', []],
            [$sites[0], 'file2.lang', 'en-US', ['obsolete', 'testflag1']],
            [$sites[0], 'file2.lang', 'fr', ['obsolete', 'testflag1', 'testflag2']],
            [$sites[1], 'file3.lang', 'en-US', []],
        ];
    }

    /**
     * @dataProvider getFileFlagsDP
     */
    public function testGetFileFlags($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->array($obj->getFileFlags($a, $b, $c))
                ->isEqualTo($d);
    }

    public function isSupportedLocaleDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'de', '', [], false],
            [$sites[1], 'de', '', [], true],
            [$sites[0], 'de', 'file1.lang', $langfiles_subsets, false],
            [$sites[0], 'fr', 'file1.lang', $langfiles_subsets, true],
            [$sites[0], 'fr', 'file2.lang', $langfiles_subsets, true],
        ];
    }

    /**
     * @dataProvider isSupportedLocaleDP
     */
    public function testIsSupportedLocale($a, $b, $c, $d, $e)
    {
        $obj = new _Project();
        $this
            ->boolean($obj->isSupportedLocale($a, $b, $c, $d))
                ->isEqualTo($e);
    }

    public function getWebsiteNameDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'reponame1'],
            [$sites[1], 'reponame2'],
        ];
    }

    /**
     * @dataProvider getWebsiteNameDP
     */
    public function testGetWebsiteName($a, $b)
    {
        $obj = new _Project();
        $this
            ->string($obj->getWebsiteName($a))
                ->isEqualTo($b);
    }

    public function getWebsiteFilesDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], ['file1.lang', 'file2.lang']],
            [$sites[1], ['file3.lang', 'file4.lang']],
        ];
    }

    /**
     * @dataProvider getWebsiteFilesDP
     */
    public function testGetWebsiteFiles($a, $b)
    {
        $obj = new _Project();
        $this
            ->array($obj->getWebsiteFiles($a))
                ->isEqualTo($b);
    }

    public function getLocalFilePathDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'fr', 'test.lang', '/private/repo1/locales/fr/test.lang'],
            [$sites[1], 'de', 'file1.lang', '/private/repo2/l10n/de/file1.lang'],
            [$sites[1], '', '', '/private/repo2/l10n/'],
        ];
    }

    /**
     * @dataProvider getLocalFilePathDP
     */
    public function testLocalGetFilePath($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->string($obj->getLocalFilePath($a, $b, $c))
                ->isEqualTo($d);
    }

    public function getPublicFilePathDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'fr', 'test.lang', '/public/repo1/locales/fr/test.lang'],
            [$sites[1], 'de', 'file1.lang', '/public/repo2/l10n/de/file1.lang'],
        ];
    }

    /**
     * @dataProvider getPublicFilePathDP
     */
    public function testPublicGetFilePath($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->string($obj->getPublicFilePath($a, $b, $c))
                ->isEqualTo($d);
    }

    public function getPublicRepoPathDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'fr', '/public/repo1/locales/fr/'],
            [$sites[1], 'de', '/public/repo2/l10n/de/'],
        ];
    }

    /**
     * @dataProvider getPublicRepoPathDP
     */
    public function testPublicGetRepoPath($a, $b, $c)
    {
        $obj = new _Project();
        $this
            ->string($obj->getPublicRepoPath($a, $b))
                ->isEqualTo($c);
    }

    public function testGetWebsitesByDataType()
    {
        require_once TEST_FILES . 'config/sources.php';

        $obj = new _Project();
        $this
            ->integer(count($obj->getWebsitesByDataType($sites, 'lang')))
                ->isEqualTo(4);

        $this
            ->integer(count($obj->getWebsitesByDataType($sites, 'raw')))
                ->isEqualTo(1);
    }

    public function getWebsiteDataTypeDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], 'lang'],
            [$sites[3], 'raw'],
        ];
    }

    /**
     * @dataProvider getWebsiteDataTypeDP
     */
    public function testGetWebsiteDataType($a, $b)
    {
        $obj = new _Project();
        $this
            ->string($obj->getWebsiteDataType($a))
                ->isEqualTo($b);
    }

    public function getWebsiteLocalRepositoryDP()
    {
        require_once TEST_FILES . 'config/sources.php';

        return [
            [$sites[0], '/private/repo1/'],
            [$sites[1], '/private/repo2/'],
        ];
    }

    /**
     * @dataProvider getWebsiteLocalRepositoryDP
     */
    public function testGetWebsiteLocalRepository($a, $b)
    {
        $obj = new _Project();
        $this
            ->string($obj->getWebsiteLocalRepository($a))
                ->isEqualTo($b);
    }

    public function getLocalizedURLDP()
    {
        return [
            [
                ['url' => 'https://www-dev.allizom.org/%LOCALE%/firefox'],
                'it',
                'txt',
                'https://www-dev.allizom.org/it/firefox',
            ],
            [
                ['url' => 'https://www-dev.allizom.org/%LOCALE%/firefox'],
                'it',
                'html',
                '<a href=\'https://www-dev.allizom.org/it/firefox\' class=\'table_small_link\'>view</a>',
            ],
            [
                ['url' => 'https://www.allizom.org/firefox'],
                'it',
                'txt',
                'https://www.allizom.org/firefox',
            ],
            [
                ['url' => 'https://www.mozilla.org/%LOCALE%/firefox'],
                '',
                'txt',
                'https://www.mozilla.org/firefox',
            ],
            [
                [],
                '',
                'txt',
                '-',
            ],
        ];
    }

    /**
     * @dataProvider getLocalizedURLDP
     */
    public function testGetLocalizedURL($a, $b, $c, $d)
    {
        $obj = new _Project();
        $this
            ->string($obj->getLocalizedURL($a, $b, $c))
                ->isEqualTo($d);
    }

    public function getUserBaseCoverageDP()
    {
        $adu = [
            'en-US'     => '10000',
            'fr'        => '2000',
            'it'        => '1000',
            'en-GB'     => '500',
            'ja'        => '250',
            'ja-JP-mac' => '250',
        ];

        return [
            [['it'], $adu, '25.00'],
            [['fr'], $adu, '50.00'],
            [['it', 'fr'], $adu, '75.00'],
        ];
    }

    /**
     * @dataProvider getUserBaseCoverageDP
     */
    public function testgetUserBaseCoverage($a, $b, $c)
    {
        $obj = new _Project();
        $this
            ->string($obj->getUserBaseCoverage($a, $b))
                ->isEqualTo($c);
    }

    public function selectViewDP()
    {
        return [
            [
                [
                    'action'   => 'activation',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'activation',
                ],
            ],
            [
                [
                    'action'   => 'count',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'countstrings',
                ],
            ],
            [
                [
                    'action'   => 'count',
                    'filename' => '',
                    'json'     => true,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'countstrings',
                ],
            ],
            [
                [
                    'action'   => 'coverage',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'getcoverage',
                ],
            ],
            [
                [
                    'action'   => 'errors',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'errors',
                ],
            ],
            [
                [
                    'action'   => 'listlocales',
                    'filename' => '',
                    'json'     => true,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'listlocalesforproject',
                ],
            ],
            [
                [
                    'action'   => 'listlocales',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'listlocales',
                ],
            ],
            [
                [
                    'action'   => 'listpages',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',                ],
                [
                    'file' => 'listpages',
                ],
            ],
            [
                [
                    'action'   => 'listpages',
                    'filename' => '',
                    'json'     => true,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',                ],
                [
                    'file' => 'listpages_api',
                ],
            ],
            [
                [
                    'action'   => 'optin',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',                ],
                [
                    'file' => 'optin',
                ],
            ],
            [
                [
                    'action'   => 'snippets',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => 'it',
                    'serial'   => false,
                    'website'  => '',                ],
                [
                    'file' => 'snippets_api',
                ],
            ],
            [
                [
                    'action'   => 'translate',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'translatestrings',
                ],
            ],
            [
                [
                    'action'   => 'translate',
                    'filename' => '',
                    'json'     => true,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'translatestrings',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => 'test.lang',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '0',
                ],
                [
                    'file' => 'globalstatus',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => 'test.lang',
                    'json'     => false,
                    'locale'   => 'it',
                    'serial'   => false,
                    'website'  => '0',
                ],
                [
                    'file' => 'globalstatus',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => 'test.lang',
                    'json'     => true,
                    'locale'   => 'it',
                    'serial'   => false,
                    'website'  => '0',
                ],
                [
                    'file' => 'globalstatus_api',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => 'test.lang',
                    'json'     => true,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '0',
                ],
                [
                    'file' => 'globalstatus_api',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => 'it',
                    'serial'   => true,
                    'website'  => '',
                ],
                [
                    'file' => 'export',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => '',
                    'json'     => true,
                    'locale'   => 'it',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'export',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => true,
                    'website'  => '',
                ],
                [
                    'file'  => 'listlocales',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => 'it',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'listsitesforlocale',
                ],
            ],
            [
                [
                    'action'   => '',
                    'filename' => '',
                    'json'     => false,
                    'locale'   => '',
                    'serial'   => false,
                    'website'  => '',
                ],
                [
                    'file' => 'listlocales',
                ],
            ],
        ];
    }

    /**
     * @dataProvider selectViewDP
     */
    public function testSelectView($a, $b)
    {
        $obj = new _Project();
        $this
            ->array($obj->selectView($a))
                ->isEqualTo($b);
    }
}
