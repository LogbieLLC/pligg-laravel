# PHPStan Issues Todo List

## GroupMember Model
- [ ] Fix undefined property `$role` (line 44)
- [ ] Fix undefined property `$role` (line 49)
- [ ] Fix undefined property `$status` (line 54)

## Link Model
- [ ] Fix undefined property `$votes` (line 104)
- [ ] Fix undefined property `$comments` (line 110)

## LoginAttempt Model
- [ ] Fix undefined property `$count` (line 46)
- [ ] Fix undefined property `$count` (line 52)

## Message Model
- [ ] Fix undefined property `$read` (line 50)
- [ ] Fix undefined property `$read_at` (line 52)

## Module Model
- [ ] Fix undefined property `$latest_version` (line 35)
- [ ] Fix undefined property `$version` (line 35)
- [ ] Fix undefined property `$folder` (line 40)
- [ ] Fix undefined property `$enabled` (line 45)

## Redirect Model
- [ ] Fix undefined property `$old_path` (line 20)

## Tag Model
- [ ] Fix undefined property `$words` (line 34)
- [ ] Fix undefined property `$words` (line 35)

## Total Model
- [ ] Fix undefined property `$total` (line 27)

## Notes
- All undefined properties need to be added to their respective model's `$fillable` and `$casts` arrays
- Properties should be properly typed in PHPDoc blocks
- Follow Laravel's model property conventions
