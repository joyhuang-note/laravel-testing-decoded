# Frequently Asked Questions #

## 3. How Do I Test Protected Methods? ##

> As a basic rule of thumb, you don’t test them. Opinions vary a bit on this issue, but, if you’d like my personal advice, only test the public interface. Those protected methods will be tested indirectly in the process. As such, if they don’t work properly, your public tests will fail.
