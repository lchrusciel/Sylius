@importexport
Feature: Export profiles
    In order to export data from my store 
    As a store owner
    I want to be able to manage export profiles

    Background:
        Given there are following export profiles configured:
            | name               | description | code        | reader   | reader_configuration                  | writer     | writer_configuration                              |
            | UsersExportProfile | Lorem ipsum | user_export | user_orm | batch_size:10,date_format:Y-m-d H:i:s | csv_writer | Delimiter:;,Enclosure:",File path:\tmp\output.csv |
        And there is default currency configured
        And there is default channel configured
        And there are following users:
            | email          | enabled  | created_at          |
            | beth@foo.com   | yes      | 2010-01-02 12:00:00 |
            | martha@foo.com | yes      | 2010-01-02 13:00:00 |
            | rick@foo.com   | yes      | 2010-01-03 12:00:00 |
        And I am logged in as administrator

    Scenario: Seeing created export profile at the list
        Given I am on the dashboard page
         When I follow "Export"
         Then I should see 1 export profiles in the list

    Scenario: Adding new export profile with default options
        Given I am on the export profile creation page
         When I fill in the following:
            | Name        | ExportProfile1    | 
            | Description | Lorem ipsum dolor |
            | Code        | export_profile    |
            | Rows number | 10                |
            | Delimiter   | ;                 |
            | Enclosure   | "                 |
            | File path   | \tmp\file.csv     |
          And I press "Create"
         Then I should be on the page of export profile "ExportProfile1"
          And I should see "Export profile has been successfully created."

    Scenario: Adding new export profile with custom options
        Given I am on the export profile creation page
         When I fill in the following:
            | Name        | ExportProfile2    | 
            | Description | Lorem ipsum dolor |
            | Code        | export_profile    |
            | Enclosure   | "                 |
            | File path   | \tmp\file.csv     |
          And I select "user_orm" from "Reader"
          And I fill in "Rows number" with "1000"
          And I fill in "Delimiter" with "*"
          And I press "Create"
         Then I should be on the page of export profile "ExportProfile2"
          And I should see "Export profile has been successfully created."
          And I should see "1000"

    Scenario: Prevent adding new export profile with the same code that has been used before
        Given I am on the export profile creation page
         When I fill in the following:
            | Name        | ExportProfile3    | 
            | Description | Lorem ipsum dolor |
            | Code        | user_export       |
            | Rows number | 10                |
            | Delimiter   | ;                 |
            | Enclosure   | "                 |
            | File path   | \tmp\file.csv     |
          And I press "Create"
         Then I should still be on the export profile creation page
          And I should see "This code is already in use."

    Scenario: Adding new export profile with empty rows number should not be allowed
       Given I am on the export profile creation page
        When I fill in the following:
          | Name        | ExportProfile3    |
          | Description | Lorem ipsum dolor |
          | Code        | user_export       |
          | Delimiter   | ;                 |
          | Enclosure   | "                 |
          | File path   | \tmp\file.csv     |
        And I press "Create"
       Then I should still be on the export profile creation page
        And I should see "This value should not be blank."

    Scenario: Accessing export profile details page from list
        Given I am on the export profile index page
         When I press "details" near "UsersExportProfile"
         Then I should be on the page of export profile "UsersExportProfile"
  
    Scenario: Accessing export profile edit form from list
        Given I am on the export profile index page
         When I press "edit" near "UsersExportProfile"
         Then I should be editing export profile with name "UsersExportProfile"

    Scenario: Accessing export profile edit form from details page
        Given I am on the page of export profile "UsersExportProfile"
         When I click "edit"
         Then I should be editing export profile with name "UsersExportProfile"

    Scenario: Updating the export profile
        Given I am editing export profile "UsersExportProfile"
         When I fill in "Name" with "UsersExportProfile2"
          And I fill in "Description" with "Lorem ipsum dolor"
          And I fill in "File path" with "\tmp\output2.csv"
          And I press "Save changes"
         Then I should see "Export profile has been successfully updated."
          And "UsersExportProfile" should appear on the page
          And "Lorem ipsum dolor" should appear on the page

    Scenario: Deleting export profile from index page
        Given I am on the export profile index page
         When I press "delete" near "UsersExportProfile"
         Then I should be on the export profile index page
          And I should see "Export profile has been successfully deleted."
          And I should see "There are no profiles to display. "

    Scenario: Deleting export profile from details page
        Given I am on the page of export profile "UsersExportProfile"
         When I press "delete"
         Then I should be on the export profile index page
          And I should see "Export profile has been successfully deleted."
          And I should see "There are no profiles to display. "
