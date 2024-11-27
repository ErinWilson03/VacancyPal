$client = New-Object System.Net.Sockets.TcpClient("193.61.191.83", 12345) 
$stream = $client.GetStream() 
$writer = New-Object System.IO.StreamWriter($stream) 
$reader = New-Object System.IO.StreamReader($stream) 
while ($true) { 
	$message = Read-Host "Enter message (type 'exit' to quit)" 
	$writer.WriteLine($message) 
	if ($message -eq "exit") { 
		break 
	} 
$response = $reader.ReadLine() 
Write-Host "Server: $response" } 
$client.Close()
