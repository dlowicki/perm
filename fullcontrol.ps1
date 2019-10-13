param (
	[string]$myGroup,
    [string]$folder
)


$folder = "C:\temp\test\"
$acl = Get-Acl $folder
$rule = New-Object System.Security.AccessControl.FileSystemAccessRule("$myGroup", "FullControl", "ContainerInherit, ObjectInherit", "None", "Allow")
$acl.AddAccessRule($rule)
Set-Acl $folder $acl