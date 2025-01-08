<?php
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{

    private $user;

    protected function setUp() : void
    {
        $this->user = new \App\Models\User();
        $this->user->setAge(33);
        //$this->user->setEmail("admin@admin.com");
    }

    protected function tearDown(): void
    {

    }

    public function testObserver() {
        $observer = $this->getMockBuilder(\App\Models\UserObserver::class)
            ->setMethods(['update'])
            ->getMock();


        $observer->expects($this->at(2))->method('update')
            ->with($this->equalTo('update'))

            /* ->with(

                 //$this->greaterThan(0)
                 //$this->stringContains('upd')
                 $this->anything()
             )*/

            /*->withConsecutive(
                [$this->stringContains('upd')],
                [$this->stringContains('upd')]
             )*/

            /*->with($this->callback(function($param) {
                return 'update234234' == $param;
             }))*/



        ;

        $this->user->attach($observer);
        $this->user->attach($observer);
        $this->user->attach($observer);

        $this->user->update();
    }

    public function testModel() {



        $db = $this->createMock(\App\Models\Db::class);

        $db = $this->getMockBuilder(\App\Models\Db::class)
        ->disableOriginalConstructor()
            //->enableOriginalConstructor()
        ->disableOriginalClone()
            //->enableOriginalClone()
        ->setMethods(['connect','query'])
            ->setMockClassName('Db')
        ->getMock();

        //$db->method('connect')->willReturn(true);

        //$db->expects($this->any())->method('connect')->willReturn(true);

        $map = [
            ['h','u','p','d',true],
            ['h','h','h','h',false],
        ];

        $db->method('connect')->will(
//            $this->returnValue(true));
            //$this->returnArgument()
            //$this->returnValueMap($map)
           $this->returnCallback(function() {
                return false;
            }));
    //$this->onConsecutiveCalls(true, false, true, true)

    //);

    /*$db->method('query')->willReturn(true);


    $db->connect('h','g','f','df');
    $db->connect('h','g','f','df');
    $this->assertTrue($this->user->save($db));*/

    }

    





}