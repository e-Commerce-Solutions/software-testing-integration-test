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

final class RBVTesting extends TestCase {
  function testTC1DP01() {
    $deposit_service = new DepositStubStub('123456789');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account no. must have 10 digit!', $result['message']);
  }
  function testTC1DP02() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(50000, $result['accBalance']);
  }
  function testTC1DP03() {
    $deposit_service = new DepositStubStub('12345678901');
    $result = $deposit_service->deposit(50000);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('Account no. must have 10 digit!', $result['message']);
  }
  function testTC1DP04() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(-1);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('จำนวนเงินฝากเข้าระบบต้องมากกว่า 0 บาท', $result['message']);
  }
  function testTC1DP05() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(0);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('จำนวนเงินฝากเข้าระบบต้องมากกว่า 0 บาท', $result['message']);
  }
  function testTC1DP06() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(1);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(1, $result['accBalance']);
  }
  function testTC1DP07() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(99999);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(99999, $result['accBalance']);
  }
  function testTC1DP08() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(100000);
    $this->assertEquals(false, $result['isError']);
    $this->assertEquals(100000, $result['accBalance']);
  }
  function testTC1DP09() {
    $deposit_service = new DepositStubStub('1234567890');
    $result = $deposit_service->deposit(100001);
    $this->assertEquals(true, $result['isError']);
    $this->assertEquals('จำนวนเงินฝากเข้าระบบต้องไม่เกิน 100,000 บาทต่อครั้ง', $result['message']);
  }
}