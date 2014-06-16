<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhalnin
 * Date: 08/06/14
 * Time: 19:00
 * To change this template use File | Settings | File Templates.
 */

namespace imei_service\command;
error_reporting( E_ALL & ~E_NOTICE );

require_once( "imei_service/domain/Unlock.php" );

class Unlock extends Command {

    function doExecute( \imei_service\controller\Request $request ) {

        $id_catalog = $request->getProperty( 'idc' );
        $id_parent = $request->getProperty( 'idp' );

        if( ! $id_catalog ) {
            $id = 0;
            $decorateCollection = \imei_service\domain\Unlock::find( $id );
            $request->setObject( 'decorateUnlock', $decorateCollection );
            $collection = \imei_service\domain\Unlock::findAll();
            $request->setObject( 'unlock', $collection );
            return self::statuses( 'CMD_INSUFFICIENT_DATA' );
        } else {
            $id = 0;
            $decorateCollection = \imei_service\domain\Unlock::find( $id );
            $request->setObject( 'decorateUnlock', $decorateCollection );
            $factory = \imei_service\mapper\PersistenceFactory::getFactory( 'imei_service\\domain\\Unlock' );
            $unlock_assembler = new \imei_service\mapper\DomainObjectAssembler( $factory );
            $unlock_idobj = new \imei_service\mapper\UnlockIdentityObject( 'id_catalog' );
            $unlock_idobj->eq( $request->getProperty( 'idc' ) )->field( 'hide' )->eq( 'show' );
            $unlock_collection = $unlock_assembler->findOne( $unlock_idobj );
//        $obj->setUnlock( $unlock_collection );
            $request->setObject( 'unlockParent', $unlock_collection );
            return self::statuses( 'CMD_OK' );
        }
    }
}
?>