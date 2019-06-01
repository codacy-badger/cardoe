<?php
declare(strict_types=1);

/**
 * This file is part of the Cardoe Framework.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Cardoe\Test\Unit\Http\Message\ServerRequest;

use InvalidArgumentException;
use Cardoe\Http\Message\ServerRequest;
use Cardoe\Http\Message\UploadedFile;
use UnitTester;

class GetUploadedFilesCest
{
    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getUploadedFiles()
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestGetUploadedFiles(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getUploadedFiles()');
        $files   = [
            new UploadedFile('php://memory', 0),
            new UploadedFile('php://memory', 0),
        ];
        $request = new ServerRequest(
            'GET',
            null,
            [],
            'php://input',
            [],
            [],
            [],
            $files
        );

        $expected = $files;
        $actual   = $request->getUploadedFiles();
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getUploadedFiles() - empty
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestGetUploadedFilesEmpty(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getUploadedFiles() - empty');
        $request = new ServerRequest();

        $actual = $request->getUploadedFiles();
        $I->assertEmpty($actual);
    }

    /**
     * Tests Cardoe\Http\Message\ServerRequest :: getUploadedFiles() -
     * exception
     *
     * @since  2019-03-03
     */
    public function httpMessageServerRequestGetUploadedFilesException(UnitTester $I)
    {
        $I->wantToTest('Http\Message\ServerRequest - getUploadedFiles() - exception');
        $I->expectThrowable(
            new InvalidArgumentException('Invalid uploaded file'),
            function () use ($I) {
                $files   = [
                    'something-else',
                ];
                $request = new ServerRequest(
                    'GET',
                    null,
                    [],
                    'php://input',
                    [],
                    [],
                    [],
                    $files
                );

                $actual = $request->getUploadedFiles();
            }
        );
    }
}