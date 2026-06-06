<?php

namespace Tests\Unit\Data;

use Tests\TestCase;
use App\Data\Location\Province;
use App\Data\Location\City;
use App\Data\Location\District;
use App\Data\Location\Address;
use InvalidArgumentException;

class LocationTest extends TestCase
{
    #region PROVINCE
    public function test_create_province(): void
    {
        $prov = new Province(1, "East Java");
        $this->assertEquals($prov->getId(), 1);
        $this->assertEquals($prov->getName(), "East Java");
    }

    public function test_province_id_illegal(): void
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Province ID must be a positive integer.');

        $prov = new Province(-1, "East Java");
    }
    public function test_province_name_illegal(): void
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Province name cannot be empty.');

        $prov = new Province(1, "    ");
    }
    #endregion

    #region CITY
    public function test_create_city(): void
    {
        $prov = new Province(1, "East Java");
        $res = new City(1, "Surabaya", $prov);
        $this->assertEquals($res->getId(), 1);
        $this->assertEquals($res->getName(), "Surabaya");
        $this->assertEquals($res->getProvince(), $prov);
    }

    public function test_city_id_illegal(): void
    {
        $prov = new Province(1, "East Java");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('City ID must be a positive integer.');

        $res = new City(-1, "Surabaya", $prov);
    }
    public function test_city_name_illegal(): void
    {
        $prov = new Province(1, "East Java");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('City name cannot be empty.');

        $res = new City(1, "    ", $prov);
    }
    #endregion
    #region DISTRICT
    public function test_create_district(): void
    {
        $prov = new Province(1, "East Java");
        $city = new City(1, "Surabaya", $prov);
        $dist = new District(1, "Gubeng", $city);
        $this->assertEquals($dist->getId(), 1);
        $this->assertEquals($dist->getName(), "Gubeng");
        $this->assertEquals($dist->getCity(), $city);
        $this->assertEquals($dist->getCity()->getProvince(), $prov);
    }

    public function test_district_id_illegal(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('District ID must be a positive integer.');

        $prov = new Province(1, "East Java");
        $city = new City(1, "Surabaya", $prov);
        $dist = new District(-1, "Gubeng", $city);
    }
    public function test_district_name_illegal(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('District name cannot be empty.');

        $prov = new Province(1, "East Java");
        $city = new City(1, "Surabaya", $prov);
        $dist = new District(1, "   ", $city);
    }
    #endregion

    #region ADDRESS
    public function test_create_address(): void
    {
        $prov = new Province(1, "East Java");
        $city = new City(1, "Surabaya", $prov);
        $dist = new District(1, "Gubeng", $city);
        $address = new Address("Jalan Raya Gubeng No.1",$dist);
        $this->assertEquals($address->getDetail(), "Jalan Raya Gubeng No.1");
        $this->assertEquals($address->getDistrict(), $dist);
        $this->assertEquals($address->getDistrict()->getCity(), $city);
        $this->assertEquals($dist->getCity()->getProvince(), $prov);
    }

    public function test_address_detail_illegal(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Address detail cannot be empty.');

        $prov = new Province(1, "East Java");
        $city = new City(1, "Surabaya", $prov);
        $dist = new District(1, "Gubeng", $city);
        $address = new Address("             ",$dist);
    }
    #endregion
}
