<?php

class ClubModel extends CtxModel
{
    public function make() {
        return '--modName:' . $this->getModName() . '--invoke:' . __METHOD__;
    }
}
