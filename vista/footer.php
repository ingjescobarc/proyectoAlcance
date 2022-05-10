</main>
</body>

<script>
    
    // Run pswmeter with options
    const myPassMeter = passwordStrengthMeter({
      containerElement: '#pswmeter',
      passwordInput: '#password',
      showMessage: true,
      messageContainer: '#pswmeter-message',
      messagesList: [
        'Write your password...',
        'Easy peasy!',
        'That is a simple one',
        'That is better',
        'Yeah! that password rocks ;)'
      ],
      height: 6,
      borderRadius: 0,
      pswMinLength: 8,
      colorScore1: '#aaa',
      colorScore2: '#aaa',
      colorScore3: '#aaa',
      colorScore4: 'limegreen'
    });
    
    </script>
</html>