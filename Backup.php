<?php
namespace FreePBX\modules\Userman;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$configs = [
			'tables' => $this->dumpTables(),
			'kvstore' => $this->dumpKVStore(),
			'settings' => $this->dumpAdvancedSettings()
		];
		$this->addConfigs($configs);
	}
}