<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__.'./../src/deposit/DepositService.php';
// require_once __DIR__.'./../src/transfer/transfer.php';
use Operation\DepositService;
// use Operation\Transfer;
class DepositStubStub extends DepositService {
  // stub service authen
  public function accountAuthenticationProvider(string $acctNum) : array
  {
    return  array(
      'accNo' => $acctNum,
      'accName' => 'Mr. Stub',
      'accBalance' => 0
    );
  }
  // stub save transaction
  public function saveTransaction(string $accNo, int $updatedBalance) : bool
  {
    return TRUE;
  }
}
final class RandomTesting extends TestCase {
  function testITDP01_10() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit('igetrich');
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Amount must be numeric!', $result['message']);
  }
  function testITDP01_11() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit('maccau888');
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Amount must be numeric!', $result['message']);
  }
  function testITDP01_12() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(55555.55);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Amount must be numeric!', $result['message']);
  }
  function testITDP01_13() {
    $deposit_service = new DepositStubStub('1234567890.1');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account no. must be numeric!', $result['message']);
  }
  function testITDP01_14() {
    $deposit_service = new DepositStubStub('igetrichst');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account no. must be numeric!', $result['message']);
  }
  function testITDP01_15() {
    $deposit_service = new DepositStubStub('maccau8888');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account no. must be numeric!', $result['message']);
  }
}