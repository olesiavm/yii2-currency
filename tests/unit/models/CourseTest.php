<?php

namespace tests\unit\models;

use olesiavm\currency\Course;

class CourseTest extends \Codeception\Test\Unit
{
    public function testGetCourses()
    {
        $course = new Course();
        expect_that($course->getAverageCourse("23-04-2020"));
        expect_that($course->getAverageCourse("23-03-2020"));
        expect_that($course->getAverageCourse("23-03-2020")['averageEur']);
        expect_that($course->getAverageCourse("23-03-2020")['averageUsd']);
    }
}
