<?
class ListValueObject {

    var $arrayList;
    var $cursor;

    function setCursorAt($index) {

        $listSize = $this->getRowCount();

        if($index >= $listsize) {
            $index = $listSize - 1;
        }

        if($index < 0) {
            $index = 0;
        }

        $this->cursor = $index;

    }

    function getCursor() {
        return $this->cursor;
    }

    function hasNext() {

        $listSize = $this->getRowCount();
        
        if($this->cursor >= $listSize) {
            return false;
        }

        return true;

    }

    function next() {

        if($this->hasNext()) {
            
            if($this->cursor == "") {
                $this->cursor = 0;
            }
           
            $vo = $this->arrayList[$this->cursor];
            $this->cursor++;
        }
        
        return $vo;
    } 

    function add($vo) {

        $this->arrayList[] = $vo;

    }

    function get($index) {

        return $this->arrayList[$index];

    }


    function getRowCount() {

        return count($this->arrayList);

    }

}
?>
