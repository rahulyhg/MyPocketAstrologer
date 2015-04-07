<?php

/*Sign up form*/
class BlankFirstNameException extends Exception
{}

class BlankLastNameException extends Exception
{}

class BlankGenderException extends Exception
{}

class BlankAddressException extends Exception
{}

class BlankPhoneException extends Exception
{}

class BlankEmailException extends Exception
{}

class UserNotExistsException extends Exception
{}

class BlankUserNameException extends Exception
{}

class UnavailableUserNameException extends Exception
{}

class BlankPasswordException extends Exception
{}

class ConfirmPasswordException extends Exception
{}

/*Login form*/
class UserInvalidException extends Exception
{}

class UserPasswordInvalidException extends Exception
{}

/*follow up exception*/

class BlankFollowUpException extends Exception
{}

class BlankPatientIdException extends Exception 
{}


/*Doctor Blank Exception*/
class BlankDoctorException extends Exception
{}

//patient discharged exception

class PatientDischargedException extends Exception
{}

class BlankDiagnosisException extends Exception
{}

/*Base Model Exceptions*/

class ModelExceptionNotExistsException extends Exception
{}

?>