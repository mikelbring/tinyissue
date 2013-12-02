# Tags Enhancement for Tiny Issue

## Installation

1. Back up your database.
2. Import update_v1-1_3_add_tags.sql using your favorite MySQL administration tool.
3. All open issues will now have a `status:open` tag associated with them, and all closed issues will have a `status:closed` tag associate with them.

## Implementation Details

- The tags `status:open` and `status:closed` are system tags, where `status:open` is forced onto open issues, and `status:closed` is forced onto closed issues.
- It is also forced that you can't have `status:closed` on open issues, or `status:open` on closed issues.
- There are two other pre-defined tags, `type:feature` and `type:bug`, and there are no other types of tags by default, but you can add your own.
- There is a tag administration interface with a color picker that allows to edit colors more easily.
- When you add or edit issues, you can specify tags using the tag field, which has a "Tag It!" plugin associated with it so that you can tag more easily.
- There are new language strings added by this enhancement.
- Only people with administration permission can add new tags, everyone else must use existing tags.
- Those who have the permission to add tags can do so when creating or editing an issue.
- Tag additions and deletions are part of all activity feeds.
- There is now an issue list control widget in each project, which allows you to do what's described in "Issue List Control Widget" section below.
- Tags can be freely defined and are not currently limited to any regular expression, but it is recommended to use tags of form `prefix:suffix`.
- All filters now use tags instead of the status field, which is now essentially obsolete.
- The status field will still be correctly updated when issues are opened or closed.

## Issue List Control Widget

The control widget allows you to:

1. Filter by specific tag or tags
2. Filter by a wildcard tag or tags, such as `type:*`
3. Filter by a mix of specific and wildcard tags
3. Choose whether to sort by a tag or by the updated field
4. Select the person and limit the list of issues to those assigned to the chosen person