<?php
namespace App\Constants;
final class Message
{
    const SUCCESS = "Success";
    const ERROR = "ERROR";
    const SERVER_ERROR = "Server error";

    // Request Project
    const FAIL_APPROVED = "Approved Fail";
    const FAIL_CANCEL = "Canceled Fail";
    const FAIL_REJECT = "Rejected Fail";
    const IS_APPROVED = "Is Approved";
    const IS_REJECTED = "Is Rejected";
    const IS_CANCEL = "Is Canceled";
    const PLANT_EXISTS_PROJECT="Plant already exists in a project";
    //defect
    const DELETE_DEFECT_FAIL = 'Delete defect fail';
}