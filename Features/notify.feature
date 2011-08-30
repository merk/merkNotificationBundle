Feature: notify
    In order to provide notifications of activities
    As a developer
    I need to use annotations to give instructions on notifying blog activities

Scenario: Trigger notification that SiteOwner created a post
    Given SiteOwner creates a new post named "My New Post"
    And the SiteOwner publishes "My New Post"
    Then a notification is created
    And a reference to the new post is persisted as the object of the notification
    And publish is persisted as the verb of the notification
    And publish is persisted as the verb of the notification
    And a reference to SiteOwner is persisted as the actor of the notification

Scenario: Trigger notification that SiteOwner updated a post
    Given SiteOwner creates a new post named "My New Post"
    And the SiteOwner publishes "My New Post"
    And the SiteOwner updates "My New Post"
    Then a notification is created
    And a reference to the new post is persisted as the object of the notification
    And update is persisted as the verb of the notification
    And a reference to SiteOwner is persisted as the actor of the notification

Scenario: Trigger notification that SiteGuest commented on a post
    Given SiteGuest creates a comment on "My New Post"
    Then a notification is created
    And a reference to the new comment is persisted as the object of the notification
    And add is persisted as the verb of the notification
    And a reference to SiteGuest is persisted as the actor of the notification

Scenario: Trigger notification that SiteOwner deletes a post
    Given SiteOwner deletes "My New Post"
    Then a notification is created
    And a reference to the new post is persisted as the object of the notification
    And delete is persisted as the verb of the notification
    And a reference to SiteOwner is persisted as the actor of the notification