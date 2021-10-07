<?php

/**

 * ContactForm class.

 * ContactForm is the data structure for keeping

 * contact form data. It is used by the 'contact' action of 'SiteController'.

 */
class MainMenus {

    public function sideMenues($flag) {
        if (method_exists($this, $flag)) {
            return $this->$flag();
        } else {
            return "<li>Impliment method <b>$flag()</b> in MainMenus.php to display the menu.</li>";
        }
    }

    public function MenuUser() {
        return
                '<li>' . CHtml::link('<i class="">Questions</i>', array('question/admin')) . '</li>'
                . '<li>' . CHtml::link('<i class="">Loan</i>', array('loan/admin')) . '</li>'
                . '<li>' . CHtml::link('<i class="">Loan Type</i>', array('loanType/admin')) . '</li>'
                . '';
    }

    public function MenuQuestion() {

        return $this->MenuUser();
    }

    public function MenuQuestionAnswers() {
        return $this->MenuUser();
    }

    public function MenuLoanType() {
        return $this->MenuUser();
    }

    public function MenuLoan() {
        return $this->MenuUser();
    }

    public function buildMenuParts($menuArray) {
        $menuString = "";
        foreach ($menuArray AS $menuPart) {
            $menuString.='<li>' . CHtml::link($menuPart[0], array($menuPart[1], 'lid' => $menuPart[2]['id']), $menuPart[2]) . '</li>';
        }
        return $menuString;
    }

    public static function getDateTime() {
        return date('y-m-d h:i:s', time());
    }

    public static function getDate() {
        return date('Y-m-d', time());
    }

    public function loanMarks($loanid) {
        $sql = 'SELECT SUM(marks) AS result FROM question_answers qa INNER JOIN answer a ON qa.questionAnswerId=a.answer AND a.loanid=' . $loanid;
        $querry = Yii::app()->db->createCommand($sql);
        $result= $querry->queryScalar();
        return ((int)$result<1)?0:$result;
    }

    public function mainGridData() {
        
    }

    public function boxItem($link, $icon, $text) {

        return '<a href="' . $link . '"><div class="box-items box-items-1 dashboard">
                    <i class="' . $icon . '"></i>
                    <h6>' . $text . '</h6>
                    <div class="whiteStripe"></div>
                </div></a>';
    }

}
