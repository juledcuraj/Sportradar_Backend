<?php
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = getTestDbConnection();
    }

    public function testDatabaseConnection()
    {
        $this->assertNotNull($this->conn, "Database connection should not be null");
        $this->assertEquals(0, $this->conn->connect_errno, "Database connection should not have errors");
    }

    public function testEventInsertion()
    {
        $sql = "INSERT INTO `match` (Season, Status, Date_Venue, Time_Venue_UTC, Sport,
                Home_Team_ID_foreignkey, Away_Team_ID_foreignkey, Stage_ID_foreignkey)
                VALUES ('2025', 'scheduled', '2025-01-01', '12:00:00', 'Football', 382, 383, 'f7a7309b-a491-11ef-9fa5-b07d64ea8bdd')";
        $result = $this->conn->query($sql);
        $this->assertTrue($result === true, "Event should be inserted successfully");
        $this->conn->query("DELETE FROM `match` WHERE Date_Venue = '2025-01-01' AND Time_Venue_UTC = '12:00:00'");
    }

    protected function tearDown(): void
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
