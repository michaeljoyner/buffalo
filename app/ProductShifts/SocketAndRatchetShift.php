<?php


namespace App\ProductShifts;


use App\Products\Category;
use App\Products\ProductOrganiser;

class SocketAndRatchetShift extends ProductsShift
{
    public function execute()
    {
        $handTools = Category::where('name', 'Hand Tools')->first();
        $oldSockets = Category::where('name', 'Sockets')->first();
        $this->guardAgainstEmpty([$handTools, $oldSockets]);

        $oldRatchetHandles = $handTools->subcategories()->where('name', 'Ratchet Handles')->first();
        $toolKits = $handTools->subcategories()->where('name', 'Tool kits')->first();
        $this->guardAgainstEmpty([$oldRatchetHandles, $toolKits]);

        $oldRatchetSets = $toolKits->productGroups()->where('name', 'Ratchet Sets')->first();
        $this->guardAgainstEmpty($oldRatchetSets);

        $socketsAndRatchets = ProductOrganiser::getNewGroup($handTools, 'Socket & Ratchet', 'Socket and Ratchets');
        $newSockets = ProductOrganiser::getNewGroup($socketsAndRatchets, 'Sockets', $oldSockets->description);
        $newRatchetHandles = ProductOrganiser::getNewGroup($socketsAndRatchets, 'Ratchet Handles', $oldRatchetHandles->description);
        $newRatchetSets = ProductOrganiser::getNewGroup($socketsAndRatchets, 'Ratchet Sets', $oldRatchetSets->description);

        ProductOrganiser::moveProducts($oldSockets, $newSockets);
        ProductOrganiser::moveProducts($oldRatchetHandles, $newRatchetHandles);
        ProductOrganiser::moveProducts($oldRatchetSets, $newRatchetSets);

        ProductOrganiser::pruneEmpty($oldSockets);
        ProductOrganiser::pruneEmpty($oldRatchetHandles);
        ProductOrganiser::pruneEmpty($oldRatchetSets);
    }
}