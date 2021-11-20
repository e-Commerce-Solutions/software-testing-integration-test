<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__.'./../src/deposit/DepositService.php';
use Operation\DepositService;
class DepositServiceAuthenticationStubSaveTransaction extends DepositService {
  // stub save transaction
  public function saveTransaction(string $accNo, int $updatedBalance) : bool
  {
    return TRUE;
  }
}
class DepositServiceStubAuthenticationSaveTransaction extends DepositService {
  // stub service authentication
  public function accountAuthenticationProvider(string $acctNum) : array
  {
    return  array(
      'accNo' => $acctNum,
      'accName' => 'Mr. Stub',
      'accBalance' => 0
    );
  }
}
final class RandomTesting extends TestCase {
  // Driver + Deposit + Service A + Stub Service B | invalid
  function testITDP02_01() {
    $deposit_service = new DepositServiceAuthenticationStubSaveTransaction('1111111111');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account number : 1111111111 not found.', $result['message']);
  }
  // Driver + Deposit + Service A + Stub Service B | valid
  function testITDP02_02() {
    $deposit_service = new DepositServiceAuthenticationStubSaveTransaction('6470272421');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(false, $result['isError']);
  }
  // Driver + Deposit + Stub Service A + Service B | invalid
  function testITDP03_01() {
    $deposit_service = new DepositServiceStubAuthenticationSaveTransaction('1111111111');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
  }
  // Driver + Deposit + Stub Service A + Service B | valid
  function testITDP03_02() {
    $deposit_service = new DepositServiceStubAuthenticationSaveTransaction('6470272421');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(50000, $result['accBalance']);
  }
  // Driver + Deposit + Service A + Service B | valid
  function testITDP04_01() {
    $deposit_service = new DepositService('6470272421');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(100000, $result['accBalance']);
  }
}