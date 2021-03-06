<?php
require_once('Testing_Base.class.php');
class Account_Model_Default_Test extends Testing_Base {

  public function testGetAccountsWToken() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccounts('ACP', FALSE, 'more', $token->token);

    $this->assertTrue($accounts !== null);
    $this->assertObjectHasAttribute('email', array_shift($accounts));
  }

  public function testGetAccounts() {
    $am = CommonModel::GetModel("Auth");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccounts('C', FALSE, 'more');

    $this->assertTrue($accounts !== null);
    $this->assertObjectHasAttribute('email', array_shift($accounts));
  }

  public function testGetAccountAdmin() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccount('Lynette', $token->token);

    $this->assertObjectHasAttribute('email', $accounts);
    $this->assertTrue($accounts !== null);
  }

  public function testGetAccountCustomer() {
    $am = CommonModel::GetModel("Auth");
    $token = $am->GetToken("Lynette", "Awesome");

    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetAccount('cl', $token->token);

    $this->assertTrue($accounts !== null);
    $this->assertObjectHasAttribute('email', $accounts);
  }

  public function testCreateAccount(){
    //As we have no way of removing an account, this test would create a new
    //every time, filling up db. This test has therefore not been implemented
    $this->assertTrue(true);
  }

  public function testUpdateAccount(){
    //As we have no way of removing an account, this test would create a new
    //every time, filling up db. This test has therefore not been implemented
    $this->assertTrue(true);
  }

  public function testGetCountries(){
    $acm = CommonModel::GetModel("Account");
    $accounts = $acm->GetCountries();

    $this->assertTrue($accounts !== null);
  }
}
