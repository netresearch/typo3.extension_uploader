<?php
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

namespace T3x\ExtensionUploader\FileFilter;

/**
 * Checks if the file contains meta data of a common VCS
 *
 * @package packagename
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class VcsMetaDataFilter implements FileFilterInterface {

	/**
	 * Gives the absolute path as parameter and expects the returning
	 * boolean to be true if the file should be skiped when packaging
	 * the extension
	 * @param $file string
	 * @return boolean
	 */
	public function excludeFile($file) {
		$filename = basename($file);
		if ($this->checkForMatch($filename)) {
			return TRUE;
		}

		$folders = explode('/', dirname($file));
		foreach ($folders as $folderName) {
			if ($this->checkForMatch($folderName)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * check if the chunk starts with a VCS meta file prefix
	 *
	 * @param $chunk string
	 * @return boolean
	 */
	protected function checkForMatch($chunk) {
		$chunk = substr($chunk, 0, 4);
		return ($chunk === '.git' || $chunk === '.svn' || substr($chunk, 0, 3) === '.hg' || $chunk === '.bzr');
	}
}
