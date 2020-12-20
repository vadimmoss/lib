</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/">Главная страница</a></li>
        <li><a href="/search">Поиск</a></li>
        <?= !empty($user) ? $user->isUserAdmin() == true ? '<li><a href="/documents/add">Добавить документ</a> </li>' : '' : '' ?>
        <?= !empty($user) ? $user->isUserAdmin() == true ? '<li><a href="/analytics">Аналитика</a> </li>' : '' : '' ?>
    </ul>
</td>
</tr>
<tr>
    <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>

</body>
</html>